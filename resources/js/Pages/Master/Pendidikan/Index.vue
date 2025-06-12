<script setup>
import { ref, onMounted, watch } from "vue";
import { apiGet, apiDelete } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { columnsIndex } from "./utils/table";
import { PenBoxIcon, SquarePlus, Trash2 } from "lucide-vue-next";
import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import DataTable from "@/components/master/DataTable.vue";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import FormDialogPendidikan from "./FormDialogPendidikan.vue";
import AlertDialog from "@/components/master/AlertDialog.vue";
import { toast } from "vue-sonner";

// State
const items = ref([]);
const totalPages = ref(1);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);
const isDialogOpen = ref(false);
const dialogMode = ref("create");
const selectedData = ref({});
const search = ref("");
const isAlertDeleteOpen = ref(false);
const selectedUuid = ref(null);
const totalData = ref(0);

// Fetch Data
const fetchData = async () => {
    try {
        isLoading.value = true;
        const res = await apiGet("/pendidikan", { page: page.value });
        items.value = res.data.data;
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
        totalData.value = res.data.total;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data pendidikan");
    } finally {
        isLoading.value = false;
    }
};

// Buka Dialog
const openDialog = (mode, data = {}) => {
    dialogMode.value = mode;
    selectedData.value = data;
    isDialogOpen.value = true;
};

// Hapus Data
// const handleDelete = async (item) => {

const onConfirmDelete = async () => {
    if (selectedUuid.value) {
        try {
            await apiDelete(`/pendidikan/${selectedUuid.value}`);
            toast.success("Data berhasil dihapus");
            fetchData();
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus data pendidikan");
        } finally {
            isAlertDeleteOpen.value = false;
            selectedUuid.value = null;
        }
    }
};

const onClickDeleteButton = (uuid) => {
    selectedUuid.value = uuid;
    isAlertDeleteOpen.value = true;
};

const onCancelDelete = () => {
    isAlertDeleteOpen.value = false;
    selectedUuid.value = null;
};

// Saat simpan data dari dialog
const handleSave = () => {
    fetchData();
    isDialogOpen.value = false;
};

// Search
const applySearch = () => {
    page.value = 1;
    fetchData();
};

// Actions Index
const actionsIndex = [
    {
        label: "Edit",
        icon: PenBoxIcon,
        handler: (item) => openDialog("edit", item),
    },
    {
        label: "Hapus",
        icon: Trash2,
        handler: (item) => onClickDeleteButton(item.uuid),
        disabled: (item) => item.penduduk_count > 0,
    },
];

// Lifecycle
onMounted(fetchData);
watch(page, fetchData);

// Auto refresh saat dialog ditutup
watch(isDialogOpen, (newVal, oldVal) => {
    if (oldVal === true && newVal === false) {
        fetchData();
    }
});
</script>

<template>
    <Head title=" | Data Pendidikan" />

    <!-- Header -->
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Pendidikan</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Data Pendidikan' },
                ]"
            />
        </div>
        <Button @click="openDialog('create')"><SquarePlus /> Pendidikan</Button>
    </div>

    <!-- Filter -->
    <div class="drop-shadow-md w-full grid gap-2">
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between"
        >
            <Input
                v-model="search"
                placeholder="Cari pendidikan berdasarkan jenjang"
                class="md:w-1/3"
            />
            <Button @click="applySearch">Terapkan</Button>
        </div>

        <DataTable
            :items="items"
            :columns="columnsIndex"
            :actions="actionsIndex"
            :totalPages="totalPages"
            :totalData="totalData"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            @update:page="page = $event"
        />
    </div>

    <FormDialogPendidikan
        v-model:isOpen="isDialogOpen"
        :mode="dialogMode"
        :initialData="selectedData"
        @save="handleSave"
        @success="fetchData"
    />

    <AlertDialog
        v-model:isOpen="isAlertDeleteOpen"
        :title="'Hapus Data Pendidikan'"
        :description="'Apakah anda yakin ingin menghapus data pendidikan ini?'"
        :onConfirm="onConfirmDelete"
        :onCancel="onCancelDelete"
    />
</template>
