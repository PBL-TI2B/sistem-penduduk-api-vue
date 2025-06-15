<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { Button } from "@/components/ui/button";
import { SquarePen, Trash2 } from "lucide-vue-next";
import { ref, onMounted } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import AlertDialog from "@/components/master/AlertDialog.vue";
import { apiGet, apiDelete } from "@/utils/api";
import { toast } from "vue-sonner";
import { useErrorHandler } from "@/composables/useErrorHandler";
import Cookies from "js-cookie";

const { uuid } = usePage().props;
const galeri = ref({});
const imageUrl = ref(null);
const isAlertDeleteOpen = ref(false);

const fetchGaleri = async () => {
    try {
        const res = await apiGet(`/galeri/${uuid}`);
        galeri.value = res.data;

        if (galeri.value.url_media) {
            const resImage = await axios.get(
                `/api/v1/galeri/url_media/${galeri.value.url_media}`,
                {
                    responseType: "blob",
                    headers: {
                        Authorization: `Bearer ${Cookies.get("token")}`,
                    },
                }
            );
            imageUrl.value = URL.createObjectURL(resImage.data);
        }
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data galeri");
    }
};

const onClickDeleteButton = () => {
    isAlertDeleteOpen.value = true;
};

const onCancelDelete = () => {
    isAlertDeleteOpen.value = false;
};

const onConfirmDelete = async () => {
    try {
        await apiDelete(`/galeri/${uuid}`);
        toast.success("Data galeri berhasil dihapus");
        router.visit("/admin/galeri");
    } catch (error) {
        useErrorHandler(error, "Gagal menghapus data galeri");
    } finally {
        isAlertDeleteOpen.value = false;
    }
};

onMounted(fetchGaleri);
</script>

<template>
    <Head title=" | Detail Galeri" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Detail Galeri</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Galeri', href: '/admin/galeri' },
                    { label: 'Detail Galeri' },
                ]"
            />
        </div>
        <div class="flex gap-2 items-center">
            <Button asChild v-if="galeri.uuid">
                <Link :href="route('galeri.edit', galeri.uuid)">
                    <SquarePen /> Ubah
                </Link>
            </Button>
            <Button @click="onClickDeleteButton"> <Trash2 /> Hapus </Button>
        </div>
    </div>
    <div
        class="shadow-md p-4 rounded-lg flex flex-col lg:flex-row gap-8 justify-between"
    >
        <div class="w-full">
            <h2 class="text-lg font-bold mb-4">
                {{ galeri.judul }}
            </h2>
            <table class="w-full gap-2 table">
                <tbody>
                    <tr>
                        <td class="font-medium p-2">Judul</td>
                        <td>{{ galeri.judul }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium p-2">Username</td>
                        <td>{{ galeri.user?.username ?? "-" }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <img
            :src="imageUrl || 'https://placehold.co/400x300?text=No+Image'"
            alt="Foto Galeri"
            loading="lazy"
            class="rounded-md w-[400px] h-[300px] object-cover border"
        />
    </div>

    <AlertDialog
        v-model:isOpen="isAlertDeleteOpen"
        :title="'Hapus Data Galeri'"
        :description="'Apakah anda yakin ingin menghapus data galeri ini?'"
        :onConfirm="onConfirmDelete"
        :onCancel="onCancelDelete"
    />
</template>
