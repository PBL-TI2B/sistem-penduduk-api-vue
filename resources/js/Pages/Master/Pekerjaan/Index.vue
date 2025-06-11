<script setup>
import { route } from "ziggy-js";
import { ref, onMounted, watch } from "vue";
import { apiGet, apiDelete } from "@/utils/api";
import { PackagePlus, SearchIcon } from "lucide-vue-next";
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
const totalData = ref(0);
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
        totalData.value = res.data.total;
        totalData.value = res.data.total;
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

const onSearchEnter = (e) => {
    if (e.key === "Enter") {
        page.value = 1;
        fetchData();
    }
};

const clearSearchPekerjaan = () => {
    searchPekerjaan.value = "";
    page.value = 1;
    fetchData();
};
</script>

<template>
    <Head title=" | Data Pekerjaan" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Pekerjaan</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Data pekerjaan' },
                ]"
            />
        </div>
    </div>
    <!-- Search -->
    <div class="drop-shadow-md w-full grid gap-2 mb-3">
        <div class="flex xl:flex-row flex-col gap-4 items-center">
            <div
                class="flex bg-primary-foreground relative items-center p-2 rounded-lg gap-2 justify-between w-full"
            >
                <Input
                    v-model="searchPekerjaan"
                    @keyup.enter="onSearchEnter"
                    placeholder="Cari data pekerjaan"
                    class="pl-10 pr-8"
                />
                <span
                    class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
                >
                    <SearchIcon class="size-6 text-muted-foreground" />
                </span>
                <button
                    v-if="searchPekerjaan"
                    @click="clearSearchPekerjaan"
                    class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                    title="Hapus pencarian"
                >
                    ✕
                </button>
            </div>
            <div
                class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between"
            >
                <Button @click="createPekerjaan"
                    ><PackagePlus />Tambah Pekerjaan
                </Button>
            </div>
        </div>
        <DataTable
            :items="items"
            :columns="columnsIndex"
            :actions="actionsIndex"
            :totalPages="totalPages"
            :total-data="totalData"
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
