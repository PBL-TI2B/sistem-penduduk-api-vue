<script setup>
import { route } from "ziggy-js";
import { ref, onMounted, watch } from "vue";

import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";

import DataTable from "@/components/master/DataTable.vue";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { actionsIndex, columnsIndex } from "./utils/table";
import { columnsJabatan } from "./utils/table";
import {
    Funnel,
    PenBoxIcon,
    SearchIcon,
    SquarePlus,
    Trash2,
    XIcon,
} from "lucide-vue-next";
import FormDialogJabatan from "./components/FormDialogJabatan.vue";
import { usePerangkatDesa } from "@/composables/usePerangkatDesa";
import { useJabatan } from "@/composables/useJabatan";
import AlertDialog from "@/components/master/AlertDialog.vue";

const isFormDialogOpen = ref(false);
const dialogMode = ref("create");
const selectedJabatan = ref(null);
const isAlertDeleteOpen = ref(false);
const selectedUuid = ref(null);

const {
    fetchPerangkatDesa,
    items,
    page,
    perPage,
    totalPages,
    totalItems,
    isLoading,
} = usePerangkatDesa();

const {
    fetchJabatan,
    deleteJabatan,
    itemsJabatan,
    perPageJabatan,
    pageJabatan,
    totalItemsJabatan,
    totalPagesJabatan,
    isLoadingJabatan,
    searchJabatan,
} = useJabatan();

const editJabatan = (jabatan) => {
    isFormDialogOpen.value = true;
    dialogMode.value = "edit";
    selectedJabatan.value = jabatan;
};

const createJabatan = () => {
    isFormDialogOpen.value = true;
    dialogMode.value = "create";
};

const actionsJabatan = [
    {
        label: "Kelola",
        icon: PenBoxIcon,
        handler: (item) => {
            editJabatan(item);
        },
    },
    {
        label: "Hapus",
        icon: Trash2,
        handler: (item) => {
            onClickDeleteButton(item.uuid);
        },
        disabled: (item) => item.perangkat_desa_count > 0,
    },
];

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
        await deleteJabatan(selectedUuid.value);
        isAlertDeleteOpen.value = false;
        selectedUuid.value = null;
    }
};

onMounted(() => {
    fetchPerangkatDesa();
    fetchJabatan();
});

const onSearchEnter = (e) => {
    if (e.key === "Enter") {
        pageJabatan.value = 1;
        fetchJabatan();
    }
};

const applyFilter = () => {
    page.value = 1;
    fetchJabatan();
};

const clearSearchJabatan = () => {
    searchJabatan.value = "";
    applyFilter();
};
watch(page, () => {
    fetchPerangkatDesa();
});

watch(pageJabatan, () => {
    fetchJabatan();
});
</script>

<template>
    <Head title=" | Data Perangkat Desa" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Perangkat Desa</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Data Perangkat Desa' },
                ]"
            />
        </div>
    </div>
    <div class="drop-shadow-md w-full grid gap-2 mb-2">
        <div class="flex xl:flex-row flex-col gap-4 items-center">
            <div
                class="flex bg-primary-foreground relative items-center p-2 rounded-lg gap-2 justify-between w-full"
            >
                <Input
                    v-model="searchJabatan"
                    @keyup.enter="onSearchEnter"
                    placeholder="Cari jabatan"
                    class="pl-10 pr8"
                />
                <span
                    class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
                >
                    <SearchIcon class="size-6 text-muted-foreground" />
                </span>
                <button
                    v-if="searchJabatan"
                    class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                    @click="clearSearchJabatan"
                    tabindex="-1"
                    type="button"
                >
                    <XIcon class="size-5" />
                </button>
            </div>
            <div
                class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between"
            >
                <Button @click="createJabatan"> <SquarePlus /> Jabatan </Button>
            </div>
        </div>

        <DataTable
            label="Jabatan"
            :items="itemsJabatan"
            :columns="columnsJabatan"
            :actions="actionsJabatan"
            :totalPages="totalPagesJabatan"
            :totalData="totalItemsJabatan"
            :page="pageJabatan"
            :per-page="perPageJabatan"
            :is-loading="isLoadingJabatan"
            @update:page="pageJabatan = $event"
        />
    </div>

    <!-- //- ! - PERANGKAT DESA :} -->
    <div class="drop-shadow-md w-full grid gap-2">
        <!-- Search & Filter -->
        <div class="flex xl:flex-row flex-col gap-4 items-center">
            <div
                class="flex bg-primary-foreground relative items-center p-2 rounded-lg gap-2 justify-between w-full"
            >
                <Input
                    id="searchPerangkat"
                    v-model="search"
                    type="text"
                    placeholder="Cari perangkat desa berdasarkan nama"
                    class="pl-10 pr-8"
                    @change="applySearchPerangkat"
                />
                <span
                    class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
                >
                    <SearchIcon class="size-6 text-muted-foreground" />
                </span>
                <button
                    v-if="search"
                    class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                    @click="search = ''"
                    tabindex="-1"
                    type="button"
                >
                    <XIcon class="size-5" />
                </button>
            </div>
            <div
                class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between items-center"
            >
                <Select v-model="selectedStatus">
                    <SelectTrigger>
                        <SelectValue placeholder="Status" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Status</SelectLabel>
                            <SelectItem value="-">Semua</SelectItem>
                            <SelectItem value="aktif">Aktif</SelectItem>
                            <SelectItem value="nonaktif">Nonaktif</SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>

                <Select v-model="selectedJabatan">
                    <SelectTrigger>
                        <SelectValue placeholder="Jabatan" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Jabatan</SelectLabel>
                            <SelectItem value="-">Semua</SelectItem>
                            <SelectItem value="ketua">Ketua RT</SelectItem>
                            <SelectItem value="ketua-rw">Ketua RW</SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>

                <Button @click="applyFilterPerangkat"
                    ><Funnel /> Terapkan</Button
                >
                <Button asChild>
                    <Link
                        :href="route('perangkat-desa.create')"
                        class="flex items-center gap-1"
                    >
                        <SquarePlus /> Perangkat Desa
                    </Link>
                </Button>
            </div>
        </div>

        <DataTable
            label="Perangkat Desa"
            :items="items"
            :columns="columnsIndex"
            :actions="actionsIndex"
            :totalPages="totalPages"
            :totalData="totalItems"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            :is-exportable="true"
            :export-route="'perangkat-desa'"
            @update:page="page = $event"
        />
    </div>

    <FormDialogJabatan
        v-model:isOpen="isFormDialogOpen"
        :mode="dialogMode"
        :initial-data="selectedJabatan"
        @success="fetchJabatan"
    />
    <AlertDialog
        v-model:isOpen="isAlertDeleteOpen"
        title="Hapus Jabatan"
        description="Apakah anda yakin ingin menghapus jabatan ini?"
        :onConfirm="onConfirmDelete"
        :onCancel="onCancelDelete"
    />
</template>
