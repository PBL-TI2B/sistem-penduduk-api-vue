<script setup>
import { route } from "ziggy-js";
import { ref, onMounted, watch } from "vue";
import { apiGet } from "@/utils/api";
import { actionsIndex, columnsIndex } from "./utils/table";
import { PackagePlus, SearchIcon } from "lucide-vue-next";

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
            <Button asChild>
                <Link :href="route('kematian.create')">+ Kematian</Link>
            </Button>
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
                    placeholder="Cari data kematian"
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
                    ✕
                </button>
            </div>
            <div
                class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between"
            >
                <Button asChild>
                    <Link :href="route('kematian.create')">+ Kematian</Link>
                </Button>
            </div>
        </div>

        <!-- Data Table -->
        <DataTable
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
