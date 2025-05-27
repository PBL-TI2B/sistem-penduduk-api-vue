<script setup>
import { Head, router } from "@inertiajs/vue3";
import { ref, onMounted, watch } from "vue";
import { apiGet, apiDelete } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { SquarePlus } from "lucide-vue-next";

import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import DataTable from "@/components/master/DataTable.vue";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import FormDialogDusun from "./components/FormDialogDusun.vue";
import FormDialogDesa from "./components/FormDialogDesa.vue";
import AlertDialog from "@/components/master/AlertDialog.vue";

import { columnsIndex, getActionsDesa } from "./utils/tableDesa";
import { columnsIndex2, getActionsDusun } from "./utils/tableDusun";

// ======================= DESA ========================
const items = ref([]);
const totalPages = ref(1);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);

// Dialog dan state hapus desa
const isFormDialogDesaOpen = ref(false);
const dialogModeDesa = ref("create");
const currentDesaData = ref(null);

const isAlertDeleteDesaOpen = ref(false);
const selectedDesaUuid = ref(null);

const fetchData = async () => {
    try {
        items.value = [];
        isLoading.value = true;
        const res = await apiGet("/desa", { page: page.value });
        items.value = res.data.data;
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data desa");
    } finally {
        isLoading.value = false;
    }
};

const createDesa = () => {
    dialogModeDesa.value = "create";
    currentDesaData.value = null;
    isFormDialogDesaOpen.value = true;
};

const editDesa = (data) => {
    dialogModeDesa.value = "edit";
    currentDesaData.value = data;
    isFormDialogDesaOpen.value = true;
};

// Fungsi buka dialog konfirmasi hapus dusun
const onClickDeleteDesa = (uuid) => {
    selectedDesaUuid.value = uuid;
    isAlertDeleteDesaOpen.value = true;
};

// Konfirmasi hapus dusun
const onConfirmDeleteDesa = async () => {
    if (selectedDesaUuid.value) {
        try {
            await apiDelete(`/desa/${selectedDesaUuid.value}`);
            await fetchData();
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus desa");
        } finally {
            isAlertDeleteDesaOpen.value = false;
            selectedDesaUuid.value = null;
        }
    }
};

// Batal hapus dusun
const onCancelDeleteDesa = () => {
    isAlertDeleteDesaOpen.value = false;
    selectedDesaUuid.value = null;
};

// Update actions dengan fungsi hapus baru
const actionsIndex = getActionsDesa({
    onEdit: editDesa,
    onDelete: (item) => onClickDeleteDesa(item.uuid),
});

onMounted(fetchData);
watch(page, fetchData);

// ======================= DUSUN ========================
const items2 = ref([]);
const totalPages2 = ref(1);
const page2 = ref(1);
const perPage2 = ref(10);
const isLoading2 = ref(false);
const search2 = ref("");

// Dialog dan state hapus dusun
const isFormDialogDusunOpen = ref(false);
const dialogModeDusun = ref("create");
const currentDusunData = ref(null);

const isAlertDeleteDusunOpen = ref(false);
const selectedDusunUuid = ref(null);

const fetchData2 = async () => {
    try {
        items2.value = [];
        isLoading2.value = true;
        const res = await apiGet("/dusun", {
            page: page2.value,
            search: search2.value,
        });
        items2.value = res.data.data;
        perPage2.value = res.data.per_page;
        totalPages2.value = res.data.last_page;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data dusun");
    } finally {
        isLoading2.value = false;
    }
};

onMounted(fetchData2);
watch([page2, search2], fetchData2);

const createDusun = () => {
    dialogModeDusun.value = "create";
    currentDusunData.value = null;
    isFormDialogDusunOpen.value = true;
};

const editDusun = (data) => {
    dialogModeDusun.value = "edit";
    currentDusunData.value = data;
    isFormDialogDusunOpen.value = true;
};

// Fungsi buka dialog konfirmasi hapus dusun
const onClickDeleteDusun = (uuid) => {
    selectedDusunUuid.value = uuid;
    isAlertDeleteDusunOpen.value = true;
};

// Konfirmasi hapus dusun
const onConfirmDeleteDusun = async () => {
    if (selectedDusunUuid.value) {
        try {
            await apiDelete(`/dusun/${selectedDusunUuid.value}`);
            await fetchData2();
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus dusun");
        } finally {
            isAlertDeleteDusunOpen.value = false;
            selectedDusunUuid.value = null;
        }
    }
};

// Batal hapus dusun
const onCancelDeleteDusun = () => {
    isAlertDeleteDusunOpen.value = false;
    selectedDusunUuid.value = null;
};

// Update actions dengan fungsi hapus baru
const actionsIndex2 = getActionsDusun({
    onEdit: editDusun,
    onDelete: (item) => onClickDeleteDusun(item.uuid),
});
</script>

<template>
    <Head title=" | Data Desa & Dusun" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Desa & Dusun</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data Desa & Dusun' },
                ]"
            />
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <Button @click="createDusun"><SquarePlus />Dusun </Button>
            <Button @click="createDesa"><SquarePlus />Desa </Button>
        </div>
    </div>

    <div class="drop-shadow-md w-full grid gap-2">
        <h2 class="text-2xl font-semibold mt-8">Data Desa</h2>
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between"
        >
            <Input
                v-model="search2"
                placeholder="Cari desa berdasarkan nama"
                class="md:w-1/3"
            />
            <div class="flex gap-4">
                <Button class="cursor-pointer" @click="fetchData"
                    >Terapkan</Button
                >
            </div>
        </div>
        <!-- TABEL DESA -->
        <DataTable
            :items="items"
            :columns="columnsIndex"
            :actions="actionsIndex"
            :totalPages="totalPages"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            @update:page="page = $event"
        />

        <FormDialogDesa
            v-model:isOpen="isFormDialogDesaOpen"
            :mode="dialogModeDesa"
            :initialData="currentDesaData"
            @success="fetchData"
        />

        <!-- TABEL DUSUN -->
        <h2 class="text-2xl font-semibold mt-8">Data Dusun</h2>
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between"
        >
            <Input
                v-model="search2"
                placeholder="Cari dusun berdasarkan nama"
                class="md:w-1/3"
            />
            <div class="flex gap-4">
                <Button class="cursor-pointer" @click="fetchData2"
                    >Terapkan</Button
                >
            </div>
        </div>

        <DataTable
            :items="items2"
            :columns="columnsIndex2"
            :actions="actionsIndex2"
            :totalPages="totalPages2"
            :page="page2"
            :per-page="perPage2"
            :is-loading="isLoading2"
            @update:page="page2 = $event"
        />

        <FormDialogDusun
            v-model:isOpen="isFormDialogDusunOpen"
            :mode="dialogModeDusun"
            :initialData="currentDusunData"
            @success="fetchData2"
        />
    </div>

    <AlertDialog
        v-model:isOpen="isAlertDeleteDusunOpen"
        title="Hapus Dusun"
        description="Apakah Anda yakin ingin menghapus dusun ini?"
        :onConfirm="onConfirmDeleteDusun"
        :onCancel="onCancelDeleteDusun"
    />

    <AlertDialog
        v-model:isOpen="isAlertDeleteDesaOpen"
        title="Hapus Desa"
        description="Apakah Anda yakin ingin menghapus desa ini?"
        :onConfirm="onConfirmDeleteDesa"
        :onCancel="onCancelDeleteDesa"
    />
</template>
