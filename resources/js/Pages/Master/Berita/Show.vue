<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { Button } from "@/components/ui/button";
import { SquarePen, Trash2 } from "lucide-vue-next";
import { ref, onMounted, computed } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import AlertDialog from "@/components/master/AlertDialog.vue";
import { apiGet, apiDelete } from "@/utils/api";
import { toast } from "vue-sonner";
import { useErrorHandler } from "@/composables/useErrorHandler";
import axios from "axios";
import Cookies from "js-cookie";
import dayjs from "dayjs";

const { slug } = usePage().props;
const berita = ref({});
const imageUrl = ref(null);
const isAlertDeleteOpen = ref(false);
const maxKontenLength = 200;

const plainKonten = computed(() => {
    if (!berita.value.konten) return "";
    let text = berita.value.konten.replace(/<[^>]+>/g, "");
    text = text.replace(/&nbsp;/g, " ");
    text = text.replace(/\n{2,}/g, "<br><br>");
    text = text.replace(/\n/g, "<br>");
    return text;
});
const kontenPendek = computed(() => {
    const text = plainKonten.value.replace(/<br>/g, "");
    return text.length > maxKontenLength
        ? plainKonten.value.slice(0, maxKontenLength) + "..."
        : plainKonten.value;
});

const fetchBerita = async () => {
    try {
        const res = await apiGet(`/berita/${slug}`);
        berita.value = res.data;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data berita");
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
        await apiDelete(`/berita/${slug}`);
        toast.success("Data berita berhasil dihapus");
        router.visit("/admin/berita");
    } catch (error) {
        useErrorHandler(error, "Gagal menghapus data berita");
    } finally {
        isAlertDeleteOpen.value = false;
    }
};

onMounted(fetchBerita);
</script>

<template>
    <Head title=" | Detail Berita" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Detail Berita</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Berita', href: '/admin/berita' },
                    { label: 'Detail Berita' },
                ]"
            />
        </div>
        <div class="flex gap-2 items-center">
            <Button asChild v-if="berita.slug">
                <Link :href="route('berita.edit', berita.slug)">
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
                {{ berita.judul }}
            </h2>
            <table class="w-full gap-2 table">
                <tbody>
                    <tr>
                        <td class="font-medium p-2">Judul</td>
                        <td>{{ berita.judul }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium p-2">Konten</td>
                        <td>
                            <div v-if="plainKonten">
                                <span
                                    v-if="
                                        plainKonten.replace(/<br>/g, '')
                                            .length > maxKontenLength
                                    "
                                    v-html="kontenPendek"
                                    style="white-space: normal"
                                ></span>
                                <span
                                    v-else
                                    v-html="plainKonten"
                                    style="white-space: normal"
                                ></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-medium p-2">Tanggal Posting</td>
                        <td>
                            {{
                                dayjs(berita.created_at).format(
                                    "DD MMM YYYY HH:mm"
                                )
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-medium p-2">Terakhir Diubah</td>
                        <td>
                            {{
                                dayjs(berita.updated_at).format(
                                    "DD MMM YYYY HH:mm"
                                )
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-medium p-2">Status</td>
                        <td>{{ berita.status }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium p-2">Jumlah Dilihat</td>
                        <td>{{ berita.jumlah_dilihat }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium p-2">Penulis</td>
                        <td>{{ berita.user?.username ?? "-" }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <img
            :src="
                `/storage/berita/${berita.thumbnail}` ||
                'https://placehold.co/400x300?text=No+Image'
            "
            alt="Thumbnail Berita"
            loading="lazy"
            class="rounded-md w-[400px] h-[300px] object-cover border"
        />
    </div>

    <AlertDialog
        v-model:isOpen="isAlertDeleteOpen"
        :title="'Hapus Data Berita'"
        :description="'Apakah anda yakin ingin menghapus data berita ini?'"
        :onConfirm="onConfirmDelete"
        :onCancel="onCancelDelete"
    />
</template>
