<script setup>
import { route } from "ziggy-js";
import { PackagePlus, SearchIcon, Eye, Trash2, PackageSearch, X } from 'lucide-vue-next';
import { ref, onMounted, watch } from "vue";
import { apiGet } from "@/utils/api";

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
    actionsIndexBantuan,
    columnsIndexBantuan,
    // actionsIndexKategori,
    columnsIndexKategori
} from "./utils/table";

import FormDialogKategoriBantuan from "./components/FormDialogKategoriBantuan.vue";
import AlertDialog from "@/components/master/AlertDialog.vue";

import { useKategoriBantuan } from "@/composables/useKategoriBantuan";
import { useErrorHandler } from "@/composables/useErrorHandler";

const {
    fetchKategori,
    deleteKategori,
    itemsKategori,
    itemsFilterKategori,
    perPageKategori,
    pageKategori,
    totalPagesKategori,
    totalDataKategori,
    isLoadingKategori,
} = useKategoriBantuan();

const items = ref([]);
const totalPages = ref(1);
const page = ref(1);
const totalData = ref(0);
const perPage = ref(10);
const isLoading = ref(false);

const search = ref(null);
const searchKategori = ref(null);

const selectedKategori = ref('-');

// kategori dialog
const isFormDialogOpen = ref(false);
const dialogMode = ref("create");
const isAlertDeleteOpen = ref(false);

// for delete
const selectedUuid = ref(null);

// Ambil data bantuan dengan filter search & kategori
const fetchBantuan = async () => {
    try {
        items.value = [];
        isLoading.value = true;
        const params = {
            page: page.value,
            search: search.value,
        };
        if (selectedKategori.value && selectedKategori.value !== "-") {
            params.kategori_bantuan_id = selectedKategori.value;
        }
        const res = await apiGet("/bantuan", params);
        items.value = res.data.data;
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
        totalData.value = res.data.total;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data bantuan");
    } finally {
        isLoading.value = false;
    }
};


const createKategoriBantuan = () => {
    isFormDialogOpen.value = true;
    dialogMode.value = "create";
};

const editKategoriBantuan = (kategori) => {
    isFormDialogOpen.value = true;
    dialogMode.value = "edit";
    selectedKategori.value = kategori;
};

const onClickDeleteButton = (uuid) => {
    selectedUuid.value = uuid;
    isAlertDeleteOpen.value = true;
};

const onCancleDelete = () => {
    isAlertDeleteOpen.value = false;
    selectedUuid.value = null;
};

const onConfirmDelete = async () => {
    if (selectedUuid.value) {
        await deleteKategori(selectedUuid.value);
        isAlertDeleteOpen.value = false;
        selectedUuid.value = null;
    }
};

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
            onClickDeleteButton(itemsKategori.uuid);
        },
    },
];

onMounted(() => {
    fetchKategori();
    fetchBantuan();
});
watch(page, () => {fetchBantuan();});
watch(pageKategori => {fetchKategori();});

const applyFilter = () => {
    page.value = 1;
    fetchBantuan();
};

const applyFilterKategori = () => {
    page.value = 1;
    fetchKategori(searchKategori.value);
};

const clearSearchKategori = () => {
    searchKategori.value = "";
    applyFilterKategori();
};
const clearSearchBantuan = () => {
    search.value = "";
    applyFilter();
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
                    id="search"
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
        v-model:isOpen="isAlertDeleteOpen"
        title="Hapus Kategori Bantuan"
        description="Apakah anda yakin ingin menghapus kategori bantuan ini?"
        :onConfirm="onConfirmDelete"
        :onCancle="onCancleDelete"
    />
</template>
