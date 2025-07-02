<script setup>
import { route } from "ziggy-js";
import { ref, onMounted, watch } from "vue";
import { apiGet } from "@/utils/api";
import { columnsIndex } from "./utils/table";
import {
    Eye,
    Funnel,
    SearchIcon,
    XIcon,
    SquarePen,
    SquarePlus,
    Trash2,
} from "lucide-vue-next";

import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import DataTable from "@/components/master/DataTable.vue";
import { useErrorHandler } from "@/composables/useErrorHandler";
import FormDialogKematian from "./components/FormDialogKematian.vue";
import AlertDialog from "@/components/master/AlertDialog.vue";
import { useKematian } from "@/composables/useKematian";
import { router } from "@inertiajs/vue3";

import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const items = ref([]);
const totalPages = ref(1);
const totalData = ref(0);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);

const isFormDialogOpen = ref(false);
const dialogMode = ref("create");
const selectedKematian = ref(null);
const isAlertDeleteOpen = ref(false);
const selectedUuid = ref(null);

const searchKematian = ref("");
const selectedMonth = ref(null);
const selectedYear = ref(null);

const actionsIndex = (onClickDeleteBantuanButton) => [
    {
        label: "Penduduk",
        icon: Eye,
        handler: (item) => {
            router.visit(route("penduduk.show", item.penduduk.uuid));
        },
    },
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
            month: selectedMonth.value,
            year: selectedYear.value,
        });
        items.value = res.data.data.map((item) => ({
            ...item,
            nama_penduduk: item.penduduk?.nama_lengkap || "-",
        }));
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
        totalData.value = res.data.total;
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
const onSearchEnter = (e) => {
    if (e.key === "Enter") {
        page.value = 1;
        fetchData();
    }
};

const clearSearchKematian = () => {
    searchKematian.value = "";
    page.value = 1;
    fetchData();
};

const monthOptions = [
    { label: "Januari", value: 1 },
    { label: "Februari", value: 2 },
    { label: "Maret", value: 3 },
    { label: "April", value: 4 },
    { label: "Mei", value: 5 },
    { label: "Juni", value: 6 },
    { label: "Juli", value: 7 },
    { label: "Agustus", value: 8 },
    { label: "September", value: 9 },
    { label: "Oktober", value: 10 },
    { label: "November", value: 11 },
    { label: "Desember", value: 12 },
];

const yearOptions = [];
const currentYear = new Date().getFullYear();
for (let i = currentYear; i >= 1990; i--) {
    yearOptions.push({ label: i.toString(), value: i });
}

const onClickFilterBulanTahun = () => {
    page.value = 1;
    fetchData();
};
const onResetFilter = () => {
    searchKematian.value = "";
    selectedMonth.value = null;
    selectedYear.value = null;
    page.value = 1;
    fetchData();
};
</script>

<template>
    <Head title=" | Data Kematian" />

    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Kematian</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Data Kematian' },
                ]"
            />
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <Button @click="createKematian"> <SquarePlus /> Kematian </Button>
        </div>
    </div>

    <!-- Search -->
    <div class="drop-shadow-md w-full grid gap-2 mb-3">
        <div class="flex xl:flex-row flex-col gap-4 items-center">
            <div
                class="flex bg-primary-foreground relative items-center p-2 rounded-lg gap-2 justify-between w-full"
            >
                <Input
                    v-model="searchKematian"
                    @keyup.enter="onSearchEnter"
                    placeholder="Cari data kematian berdasarkan nama penduduk"
                    class="pl-10 pr-8"
                />
                <span
                    class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
                >
                    <SearchIcon class="size-6 text-muted-foreground" />
                </span>
                <button
                    v-if="searchKematian"
                    @click="clearSearchKematian"
                    class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                    title="Hapus pencarian"
                >
                    <XIcon />
                </button>
            </div>
            <div
                class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between"
            >
                <select
                    v-model="selectedMonth"
                    class="border rounded-md px-3 py-2"
                >
                    <option :value="null" disabled>Pilih Bulan</option>
                    <option
                        v-for="month in monthOptions"
                        :key="month.value"
                        :value="month.value"
                    >
                        {{ month.label }}
                    </option>
                </select>

                <select
                    v-model="selectedYear"
                    class="border rounded-md px-3 py-2"
                >
                    <option :value="null" disabled>Pilih Tahun</option>
                    <option
                        v-for="year in yearOptions"
                        :key="year.value"
                        :value="year.value"
                    >
                        {{ year.label }}
                    </option>
                </select>

                <Button @click="onClickFilterBulanTahun">
                    <Funnel /> Terapkan
                </Button>
                <Button
                    @click="onResetFilter"
                    variant="ghost"
                    class="p-2 w-8 h-8 flex items-center justify-center text-muted-foreground"
                    title="Reset Filter"
                >
                    <XIcon class="w-4 h-4" />
                </Button>
            </div>
        </div>

        <!-- Data Table -->
        <DataTable
            label="Kematian"
            :items="items"
            :columns="columnsIndex"
            :actions="actionsIndexKematian"
            :totalPages="totalPages"
            :total-data="totalData"
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

<style scoped>
:deep(.dp__cell_inner.dp__active_date) {
    background-color: oklch(0.31 0.0702 152.07) !important; /* biru */
    color: white !important;
    border-radius: 6px;
}

:deep(.dp__cell_inner.dp__today) {
    border: 2px solid oklch(0.31 0.0702 152.07); /* border biru */
    border-radius: 6px;
}

:deep(.dp__action_button) {
    background-color: oklch(0.31 0.0702 152.07); /* warna latar */
    color: white; /* warna teks */
    border-radius: 6px;
    border: none;
}

:deep(.dp__action_button:hover) {
    background-color: oklch(0.22 0.0049 158.96); /* saat hover */
}
</style>
