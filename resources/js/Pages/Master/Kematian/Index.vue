<script setup>
import { route } from "ziggy-js";
import { ref, onMounted, watch } from "vue";
import { apiGet } from "@/utils/api";
import { columnsIndex } from "./utils/table";

import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import DataTable from "@/components/master/DataTable.vue";
import { useErrorHandler } from "@/composables/useErrorHandler";
import FormDialogKematian from "./components/FormDialogKematian.vue";
import { SquarePen, SquarePlus, Trash2 } from "lucide-vue-next";
import AlertDialog from "@/components/master/AlertDialog.vue";
import { useKematian } from "@/composables/useKematian";

const items = ref([]);
const totalPages = ref(1);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);
const totalData = ref(0);

const isFormDialogOpen = ref(false);
const dialogMode = ref("create");
const selectedKematian = ref(null);
const isAlertDeleteOpen = ref(false);
const selectedUuid = ref(null);

const searchKematian = ref("");

const actionsIndex = (onClickDeleteBantuanButton) => [
    {
        label: "Ubah",
        icon: SquarePen,
        handler: (item) => {
            editKematian(item);
        },
    },
    {
        label: "Hapus",
        icon: Trash2,
        handler: (item) => {
            onClickDeleteBantuanButton(item.uuid);
        },
        disabled: (item) => item.penerima_bantuan_count > 0,
    },
];

const onClickDeleteKematianButton = (uuid) => {
    selectedUuid.value = uuid;
    isAlertDeleteOpen.value = true;
};

const actionsIndexKematian = actionsIndex(onClickDeleteKematianButton);

const fetchData = async () => {
    try {
        isLoading.value = true;
        const res = await apiGet("/kematian", {
            page: page.value,
            search: searchKematian.value,
        });
        items.value = res.data.data.map((item) => ({
            ...item,
            nama_penduduk: item.penduduk?.nama_lengkap || "-",
        }));
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
        totalData.value = res.data.total;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data kematian");
    } finally {
        isLoading.value = false;
    }
};

const { deleteData } = useKematian();

const editKematian = (kematian) => {
    isFormDialogOpen.value = true;
    dialogMode.value = "edit";
    selectedKematian.value = kematian;
};

const createKematian = () => {
    isFormDialogOpen.value = true;
    dialogMode.value = "create";
};

const onCancelDeleteKematian = () => {
    isAlertDeleteOpen.value = false;
    selectedUuid.value = null;
};
const onConfirmDeleteKematian = async () => {
    if (selectedUuid.value) {
        await deleteData(selectedUuid.value);
        isAlertDeleteOpen.value = false;
        selectedUuid.value = null;
    }
};

onMounted(fetchData);
watch(page, fetchData);
watch(searchKematian, () => {
    page.value = 1;
    fetchData();
});
</script>

<template>
    <Head title=" | Data Kematian" />

    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Kematian</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data Kematian' },
                ]"
            />
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <Button @click="createKematian"> <SquarePlus /> Kematian </Button>
        </div>
    </div>

    <!-- Search -->
    <div class="drop-shadow-md w-full grid gap-2">
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between items-center"
        >
            <Input
                v-model="searchKematian"
                placeholder="Cari data kematian berdasarkan nama atau sebab"
                class="md:w-1/3"
            />
        </div>

        <!-- Data Table -->
        <DataTable
            :items="items"
            :columns="columnsIndex"
            :actions="actionsIndexKematian"
            :totalPages="totalPages"
            :totalData="totalData"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            :export-route="'kematian'"
            @update:page="page = $event"
        />

        <FormDialogKematian
            v-model:isOpen="isFormDialogOpen"
            :mode="dialogMode"
            :initialData="selectedKematian"
            @success="fetchData"
        />

        <AlertDialog
            v-model:isOpen="isAlertDeleteOpen"
            title="Hapus Data Kematian"
            description="Apakah anda yakin ingin menghapus data kematian ini?"
            :onConfirm="onConfirmDeleteKematian"
            :onCancel="onCancelDeleteKematian"
        />
    </div>
</template>
