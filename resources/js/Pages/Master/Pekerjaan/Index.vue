<script setup>
import { route } from "ziggy-js";
import { ref, onMounted, watch } from "vue";
import { apiGet, apiDelete } from "@/utils/api";
import { SquarePlus } from "lucide-vue-next";
import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import FormDialogPekerjaan from "./components/FormDialogPekerjaan.vue";
import AlertDialog from "@/components/master/AlertDialog.vue";

import DataTable from "@/components/master/DataTable.vue";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { columnsIndex, getActionsPekerjaan } from "./utils/table";
import { useErrorHandler } from "@/composables/useErrorHandler";

const items = ref([]);
const totalPages = ref(1);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);

const isFormDialogPekerjaanOpen = ref(false);
const dialogModePekerjaan = ref("create");
const currentPekerjaanData = ref(null);

const isAlertDeletePekerjaanOpen = ref(false);
const selectedPekerjaanUuid = ref(null);

const searchPekerjaan = ref("");

const fetchData = async () => {
    try {
        items.value = [];
        isLoading.value = true;
        const res = await apiGet("/pekerjaan", {
            page: page.value,
            search: searchPekerjaan.value,
        });
        items.value = res.data.data.map((item) => ({
            ...item,
            nama_pekerjaan: item.nama_pekerjaan || "-",
        }));
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data pekerjaan");
    } finally {
        isLoading.value = false;
    }
};

const createPekerjaan = () => {
    dialogModePekerjaan.value = "create";
    currentPekerjaanData.value = null;
    isFormDialogPekerjaanOpen.value = true;
};

const editPekerjaan = (data) => {
    dialogModePekerjaan.value = "edit";
    currentPekerjaanData.value = data;
    isFormDialogPekerjaanOpen.value = true;
};

// Fungsi buka dialog konfirmasi hapus dusun
const onClickDeletePekerjaan = (uuid) => {
    selectedPekerjaanUuid.value = uuid;
    isAlertDeletePekerjaanOpen.value = true;
};

// Konfirmasi hapus dusun
const onConfirmDeletePekerjaan = async () => {
    if (selectedPekerjaanUuid.value) {
        try {
            await apiDelete(`/pekerjaan/${selectedPekerjaanUuid.value}`);
            await fetchData();
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus Pekerjaan");
        } finally {
            isAlertDeletePekerjaanOpen.value = false;
            selectedPekerjaanUuid.value = null;
        }
    }
};

// Batal hapus dusun
const onCancelDeletePekerjaan = () => {
    isAlertDeletePekerjaanOpen.value = false;
    selectedPekerjaanUuid.value = null;
};

// Update actions dengan fungsi hapus baru
const actionsIndex = getActionsPekerjaan({
    onEdit: editPekerjaan,
    onDelete: (item) => onClickDeletePekerjaan(item.uuid),
});

onMounted(fetchData);
watch(page, fetchData);
watch(searchPekerjaan, () => {
    page.value = 1;
    fetchData();
});
</script>

<template>
    <Head title=" | Data Pekerjaan" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Pekerjaan</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data pekerjaan' },
                ]"
            />
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <Button @click="createPekerjaan"><SquarePlus />Pekerjaan </Button>
        </div>
    </div>
    <!-- Search -->
    <div class="drop-shadow-md w-full grid gap-2">
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between items-center"
        >
            <Input
                v-model="searchPekerjaan"
                placeholder="Cari data pekerjaan"
                class="md:w-1/3"
            />
        </div>
        <DataTable
            :items="items"
            :columns="columnsIndex"
            :actions="actionsIndex"
            :totalPages="totalPages"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            :export-route="'penduduk'"
            @update:page="page = $event"
        />

        <FormDialogPekerjaan
            v-model:isOpen="isFormDialogPekerjaanOpen"
            :mode="dialogModePekerjaan"
            :initialData="currentPekerjaanData"
            @success="fetchData"
        />

        <AlertDialog
            v-model:isOpen="isAlertDeletePekerjaanOpen"
            title="Hapus Pekerjaan"
            description="Apakah Anda yakin ingin menghapus pekerjaan ini?"
            :onConfirm="onConfirmDeletePekerjaan"
            :onCancel="onCancelDeletePekerjaan"
        />
    </div>
</template>
