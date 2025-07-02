<script setup>
import { ref, onMounted, watch } from "vue";
import { apiGet, apiDelete } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { columnsIndex } from "./utils/table";
import { PenBoxIcon, SquarePlus, Trash2, SearchIcon } from "lucide-vue-next";
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
const isAlertDeleteOpen = ref(false);
const selectedUuid = ref(null);
const totalData = ref(0);

const searchPendidikan = ref("");

// Fetch Data
const fetchData = async () => {
    try {
        items.value = [];
        isLoading.value = true;
        const res = await apiGet("/pendidikan", {
            page: page.value,
            search: searchPendidikan.value,
        });
        items.value = res.data.data.map((item) => ({
            ...item,
            jenjang: item.jenjang || "-",
        }));
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
        totalData.value = res.data.total;
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
        disabled: (item) => item.penduduk_count > 0,
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

const onSearchEnter = (e) => {
    if (e.key === "Enter") {
        page.value = 1;
        fetchData();
    }
};

const clearSearchPendidikan = () => {
    searchPendidikan.value = "";
    page.value = 1;
    fetchData();
};
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
    </div>

    <!-- Search -->
    <div class="drop-shadow-md w-full grid gap-2 mb-3">
        <div class="flex xl:flex-row flex-col gap-4 items-center">
            <div
                class="flex bg-primary-foreground relative items-center p-2 rounded-lg gap-2 justify-between w-full"
            >
                <Input
                    v-model="searchPendidikan"
                    @keyup.enter="onSearchEnter"
                    placeholder="Cari data pendidikan"
                    class="pl-10 pr-8"
                />
                <span
                    class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
                >
                    <SearchIcon class="size-6 text-muted-foreground" />
                </span>
                <button
                    v-if="searchPendidikan"
                    @click="clearSearchPendidikan"
                    class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                    title="Hapus pencarian"
                >
                    ✕
                </button>
            </div>
            <div
                class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between"
            >
                <Button @click="openDialog('create')"
                    ><SquarePlus />Tambah Pendidikan
                </Button>
            </div>
        </div>
    </div>
    <DataTable
        label="Pendidikan"
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
