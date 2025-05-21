<script setup>
import { route } from "ziggy-js";
import { ref, onMounted, watch } from "vue";
import { router, Link } from '@inertiajs/vue3';

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
import { Label } from "@/components/ui/label";
import DataTable from "@/components/master/DataTable.vue";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import {
    columnsIndexBantuan,
    columnsIndexKategori,
} from "./utils/table";

import FormDialogKategoriBantuan from "./components/FormDialogKategoriBantuan.vue";
import AlertDialog from "@/components/master/AlertDialog.vue";

import { PackagePlus, SearchIcon, Eye, Trash2, PackageSearch, X, FunnelX, SquarePen } from 'lucide-vue-next';

import { useBantuan } from "@/composables/useBantuan";
import { useKategoriBantuan } from "@/composables/useKategoriBantuan";

// --- GUNAKAN useKategoriBantuan ---
const {
    fetchKategori,
    deleteKategori,
    itemsKategori,
    itemsFilterKategori,
    perPageKategori,
    pageKategori,
    searchKategori,
    totalPagesKategori,
    totalDataKategori,
    isLoadingKategori,
} = useKategoriBantuan();

// --- GUNAKAN useBantuan ---
const {
    items,
    totalPages,
    page,
    totalData,
    perPage,
    search,
    selectedKategori,
    isLoading,
    fetchBantuan,
    deleteBantuan,
    fetchDetailBantuan,
} = useBantuan();


// kategori dialog
const isFormDialogOpen = ref(false);
const dialogMode = ref("create");
const isAlertDeleteKategoriOpen = ref(false);

// bantuan dialog
const isAlertDeleteBantuanOpen = ref(false);

// for delete
const selectedKategoriUuid = ref(null);
const selectedBantuanUuid = ref(null);

onMounted(() => {
    fetchKategori();
    fetchBantuan();
});

watch(page, fetchBantuan);
watch(pageKategori, fetchKategori);

const actionsIndexBantuan = [
    {
        label: "Kelola",
        icon: Eye,
        handler: (item) => {
            router.visit(route("bantuan.show", item.uuid));
        },
    },
    {
        label: "Ubah",
        icon: SquarePen,
        handler: (item) => {
            router.visit(route("bantuan.edit", item.uuid));
        },
    },
    {
        label: "Hapus",
        icon: Trash2,
        handler: (item) => {
            // Implement your delete logic here, e.g.:
            onClickDeleteBantuanButton(item.uuid);
        },
    },
];

const actionsIndexKategori = [
    {
        label: "Saring",
        icon: PackageSearch,
        handler: (itemsKategori) => {
            selectedKategori.value = itemsKategori.id;
            applyFilter();
        },
    },
    {
        label: "Ubah",
        icon: Eye,
        handler: (itemsKategori) => {
            editKategoriBantuan(itemsKategori);
        },
    },
    {
        label: "Hapus",
        icon: Trash2,
        handler: (itemsKategori) => {
            onClickDeleteKategoriButton(itemsKategori.uuid);
        },
    },
];

//  -- Events Bantuan --
const onClickDeleteBantuanButton = (uuid) => {
    selectedBantuanUuid.value = uuid;
    isAlertDeleteBantuanOpen.value = true;
};
const onCancelDeleteBantuan = () => {
    isAlertDeleteBantuanOpen.value = false;
    selectedBantuanUuid.value = null;
};
const onConfirmDeleteBantuan = async () => {
    if (selectedBantuanUuid.value) {
        await deleteBantuan(selectedBantuanUuid.value);
        isAlertDeleteBantuanOpen.value = false;
        selectedBantuanUuid.value = null;
    }
};

//  -- Events Kategori Bantuan --
const createKategoriBantuan = () => {
    isFormDialogOpen.value = true;
    dialogMode.value = "create";
};
const editKategoriBantuan = (kategori) => {
    isFormDialogOpen.value = true;
    dialogMode.value = "edit";
    selectedKategori.value = kategori;
};
const onClickDeleteKategoriButton = (uuid) => {
    selectedKategoriUuid.value = uuid;
    isAlertDeleteKategoriOpen.value = true;
};
const onCancelDeleteKategori = () => {
    isAlertDeleteKategoriOpen.value = false;
    selectedKategoriUuid.value = null;
};
const onConfirmDeleteKategori = async () => {
    if (selectedKategoriUuid.value) {
        await deleteKategori(selectedKategoriUuid.value);
        isAlertDeleteKategoriOpen.value = false;
        selectedKategoriUuid.value = null;
    }
};

//  -- Filter Bantuan --
const applyFilter = () => {
    page.value = 1;
    fetchBantuan();
};
const resetFilter = () => {
    search.value = "";
    selectedKategori.value = "-";
    applyFilter();
};
const clearSearchBantuan = () => {
    search.value = "";
    applyFilter();
};

//  -- Filter Kategori Bantuan --
const applyFilterKategori = () => {
    pageKategori.value = 1;
    fetchKategori();
};
const clearSearchKategori = () => {
    searchKategori.value = "";
    applyFilterKategori();
};

</script>

<template>
    <Head title=" | Data Bantuan" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Bantuan</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data bantuan' },
                ]"
            />
        </div>
    </div>
    <div class="drop-shadow-md w-full grid gap-2">

        <!-- Search Kategori -->
        <div class="flex xl:flex-row flex-col gap-4 items-center">
            <div class="flex bg-primary-foreground relative items-center p-2 rounded-lg gap-2 justify-between w-full">
                <Input
                    id="searchKategori"
                    v-model="searchKategori"
                    type="text"
                    placeholder="Cari kategori bantuan"
                    class="pl-10 pr-8"
                    @change="applyFilterKategori"
                />
                <span class="absolute start-2 inset-y-0 flex items-center justify-center px-2">
                    <SearchIcon class="size-6 text-muted-foreground" />
                </span>
                <button
                    v-if="searchKategori"
                    class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                    @click="clearSearchKategori"
                    tabindex="-1"
                    type="button"
                >
                    <X class="size-5" />
                </button>
            </div>
            <div class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between">
                <Button @click="createKategoriBantuan"> <PackagePlus/>  Tambah Kategori Bantuan </Button>
            </div>
        </div>

        <DataTable
            label="Kategori Bantuan"
            :items="itemsKategori"
            :columns="columnsIndexKategori"
            :actions="actionsIndexKategori"
            :totalPages="totalPagesKategori"
            :totalData="totalDataKategori"
            :page="pageKategori"
            :per-page="perPageKategori"
            :is-loading="isLoadingKategori"
            @update:page="pageKategori = $event"
        />

        <!-- Search Bantuan -->
        <div class="flex xl:flex-row flex-col gap-4 mt-4 items-center">
            <div class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between w-full">
                <div class="flex w-full relative items-center">
                    <Input
                        id="search"
                        v-model="search"
                        type="text"
                        placeholder="Cari bantuan"
                        class="pl-10 pr-8"
                        @change="applyFilter"
                    />
                    <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                        <SearchIcon class="size-6 text-muted-foreground" />
                    </span>
                    <button
                        v-if="search"
                        class="absolute end-0 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                        @click="clearSearchBantuan"
                        tabindex="-1"
                        type="button"
                    >
                        <X class="size-5" />
                    </button>
                </div>
                <div class="flex gap-2 items-center">
                    <Label for="kategori">Kategori:</Label>
                    <Select v-model="selectedKategori" @update:modelValue="applyFilter" id="kategori">
                        <SelectTrigger>
                            <SelectValue placeholder="Kategori" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Kategori</SelectLabel>
                                <SelectItem
                                    v-for="kat in itemsFilterKategori"
                                    :key="kat.value"
                                    :value="kat.value"
                                >
                                    {{ kat.label }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <Button asChild
                        @click="resetFilter"
                    >
                        <div>
                            <FunnelX/>
                            Reset
                        </div>
                    </Button>
                </div>
            </div>
            <div class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between">
                <Button asChild >
                    <Link :href="route('bantuan.create')">
                        <PackagePlus/>
                        Tambah Bantuan
                    </Link>
                </Button>
            </div>
        </div>

        <DataTable
            label="Bantuan"
            :items="items"
            :columns="columnsIndexBantuan"
            :actions="actionsIndexBantuan"
            :totalPages="totalPages"
            :totalData="totalData"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            :is-exportable="true"
            :export-route="'bantuan'"
            @update:page="page = $event"
        />

    </div>
    <FormDialogKategoriBantuan
        v-model:isOpen="isFormDialogOpen"
        :mode="dialogMode"
        :initial-data="selectedKategori"
        @success="fetchKategori"
    />
    <AlertDialog
        v-model:isOpen="isAlertDeleteKategoriOpen"
        title="Hapus Kategori Bantuan"
        description="Apakah anda yakin ingin menghapus kategori bantuan ini?"
        :onConfirm="onConfirmDeleteKategori"
        :onCancel="onCancelDeleteKategori"
    />
    <AlertDialog
        v-model:isOpen="isAlertDeleteBantuanOpen"
        title="Hapus Bantuan"
        description="Apakah anda yakin ingin menghapus bantuan ini?"
        :onConfirm="onConfirmDeleteBantuan"
        :onCancel="onCancelDeleteBantuan"
    />
</template>
