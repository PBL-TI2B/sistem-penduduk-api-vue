<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { Button } from "@/components/ui/button";
import { SquarePen, Trash2 } from "lucide-vue-next";
import { rowsShow } from "./utils/table";
import { onMounted, ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import FormDialogDomisili from "./components/FormDialogDomisili.vue";
import { usePenduduk } from "@/composables/usePenduduk";
import DomisiliSection from "./components/TableDomisiliSection.vue";
import AlertDialog from "@/components/master/AlertDialog.vue";

const { uuid } = usePage().props;
const selectedUuid = ref(null);
const isFormDialogDomisiliOpen = ref(false);
const isAlertDeleteOpen = ref(false);
const dialogMode = ref("create");

const { items, imageUrl, fetchDetailPenduduk, deletePenduduk, deleteDomisili } =
    usePenduduk(uuid);

const currentPendudukData = computed(() => items.value);

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

const editDomisiliPenduduk = (user) => {
    isFormDialogDomisiliOpen.value = true;
    dialogMode.value = "edit";
    items.value = user;
};

const createDomisiliPenduduk = () => {
    isFormDialogDomisiliOpen.value = true;
    dialogMode.value = "create";
};

onMounted(fetchDetailPenduduk);
</script>

<template>
    <Head title=" | Detail Penduduk" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Penduduk</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Data Penduduk', href: '/admin/penduduk' },
                    { label: 'Detail Penduduk' },
                ]"
            />
        </div>
        <div class="flex gap-2 items-center">
            <Button asChild>
                <Link :href="route('penduduk.edit', uuid)">
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
                Detail Data {{ items.nama_lengkap }}
            </h2>
            <table class="w-full gap-2 table">
                <tr
                    v-for="row in rowsShow.slice(0, -5)"
                    :key="row.key"
                    class="even:bg-card/30 p-2"
                >
                    <td class="font-medium p-2">
                        {{ row.label }}
                    </td>
                    <td>
                        {{
                            row.format
                                ? row.format(items[row.key], items)
                                : items[row.key]
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
            alt="Foto Penduduk"
            loading="lazy"
            class="rounded-md w-[450px] h-[600px] object-cover"
        />
    </div>

    <DomisiliSection
        :items="items"
        :createDomisiliPenduduk="createDomisiliPenduduk"
        :editDomisiliPenduduk="editDomisiliPenduduk"
        :deleteDomisili="deleteDomisili"
    />

    <FormDialogDomisili
        v-model:isOpen="isFormDialogDomisiliOpen"
        :mode="dialogMode"
        :initialData="currentPendudukData"
        @success="fetchDetailPenduduk"
    />

    <AlertDialog
        v-model:isOpen="isAlertDeleteOpen"
        :title="'Hapus Data Penduduk'"
        :description="'Apakah anda yakin ingin menghapus data penduduk ini?'"
        :onConfirm="onConfirmDelete"
        :onCancel="onCancelDelete"
    />
</template>
