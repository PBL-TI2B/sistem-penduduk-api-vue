<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { Button } from "@/components/ui/button";
import { SquarePen, Trash2 } from "lucide-vue-next";
import { rowsShow } from "./utils/table";
import { onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { apiGet } from "@/utils/api";
import AlertDialog from "@/components/master/AlertDialog.vue";
import Cookies from "js-cookie";

const { uuid } = usePage().props;
const item = ref({});
const imageUrl = ref(null);
const isAlertDeleteOpen = ref(false);
const selectedUuid = ref(null);

const onClickDeleteButton = (uuid) => {
    selectedUuid.value = uuid;
    isAlertDeleteOpen.value = true;
};

const onCancelDelete = () => {
    isAlertDeleteOpen.value = false;
    selectedUuid.value = null;
};

const onConfirmDelete = async () => {
    if (selectedUuid.value) {
        await deletePenduduk(selectedUuid.value);
        isAlertDeleteOpen.value = false;
        selectedUuid.value = null;
    }
};

const fetchDetailPerangkatDesa = async () => {
    try {
        const res = await apiGet(`/perangkat-desa/${uuid}`);
        item.value = res.data;

        if (item.value.foto) {
            const resImage = await axios.get(
                `/api/v1/penduduk/foto/${item.value.foto}`,
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
        useErrorHandler(error, "Gagal mendapatkan data perangkat desa");
    }
};

onMounted(fetchDetailPerangkatDesa);
</script>

<template>
    <Head title=" | Detail Perangkat Desa" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Perangkat Desa</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data Perangkat Desa', href: '/perangkat-desa' },
                    { label: 'Detail Perangkat Desa' },
                ]"
            />
        </div>
        <div class="flex gap-2 items-center">
            <Button asChild>
                <Link :href="route('perangkat-desa.edit', uuid)">
                    <SquarePen /> Ubah
                </Link>
            </Button>
            <Button @click="onClickDeleteButton(uuid)">
                <Trash2 /> Hapus
            </Button>
        </div>
    </div>
    <div
        class="shadow-md p-2 rounded-lg flex flex-col lg:flex-row gap-2 justify-between"
    >
        <div class="w-full">
            <h2 class="text-lg font-bold p-2">
                Detail Data {{ item.penduduk?.nama_lengkap }}
            </h2>
            <table class="w-full gap-2 table">
                <tr
                    v-for="row in rowsShow"
                    :key="row.key"
                    class="even:bg-card/30 p-2"
                >
                    <td class="font-medium p-2">
                        {{ row.label }}
                    </td>
                    <td>
                        {{
                            row.format
                                ? row.format(item[row.key], item)
                                : item[row.key]
                        }}
                    </td>
                </tr>
            </table>
        </div>
        <img
            :src="
                imageUrl
                    ? imageUrl
                    : 'https://placehold.co/300x400?text=No+Photo'
            "
            alt="Foto Perangkat Desa"
            loading="lazy"
            class="rounded-md w-[450px] h-[600px] object-cover"
        />
    </div>

    <AlertDialog
        v-model:isOpen="isAlertDeleteOpen"
        title="Hapus Perangkat Desa"
        description="Apakah anda yakin ingin menghapus perangkat desa ini?"
        :onConfirm="onConfirmDelete"
        :onCancel="onCancelDelete"
    />
</template>
