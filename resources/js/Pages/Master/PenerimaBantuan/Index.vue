<script setup>
import { route } from "ziggy-js";
import { ref, onMounted, watch } from "vue";
import { apiGet } from "@/utils/api";

import {
    PackagePlus,
    SearchIcon,
    Eye,
    Trash2,
    PackageSearch,
    X,
    FunnelX,
    SquarePen,
} from "lucide-vue-next";

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
import { useErrorHandler } from "@/composables/useErrorHandler";
import { usePenerimaBantuan } from "@/composables/usePenerimaBantuan";

const {
    items,
    item,
    isLoading,
    page,
    perPage,
    totalPages,
    totalItems,
    search,
    selectedStatusPenerimaanBantuan,
    // statusValidasiOptions,
    // imageUrl,
    fetchData,
    fetchDetailData,
    createData,
    editKeterangan,
    editStatusPenerimaanBantuan,
    deleteData,
} = usePenerimaBantuan();

const clearSearch = () => {
    search.value = "";
    page.value = 1;
    fetchData();
};

const applyFilter = () => {
    page.value = 1;
    fetchData();
};

const resetFilter = () => {
    search.value = "";
    selectedStatusPenerimaanBantuan.value = "";
    applyFilter();
};

onMounted(() => {
    fetchData();
});

watch(page, () => {
    fetchData();
});
</script>

<template>
    <Head title=" | Data Penerima Bantuan" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Penerima Bantuan</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Data Penerima Bantuan' },
                ]"
            />
        </div>
        <!-- <div class="flex flex-wrap gap-4 items-center">
            <Button asChild>
                <Link :href="route('kurang-mampu.create')">
                    + Penerima Bantuan</Link
                >
            </Button>
        </div> -->
    </div>
    <div class="drop-shadow-md w-full grid gap-2 mb-3">
        <div class="flex xl:flex-row flex-col gap-4 items-center">
            <div
                class="flex bg-primary-foreground relative items-center p-2 rounded-lg gap-2 justify-between w-full"
            >
                <div class="flex w-full relative items-center">
                    <Input
                        id="search"
                        v-model="search"
                        type="text"
                        placeholder="Cari penerima bantuan"
                        class="pl-10 pr-8"
                        @change="applyFilter"
                    />
                    <span
                        class="absolute start-2 inset-y-0 flex items-center justify-center"
                    >
                        <SearchIcon class="size-6 text-muted-foreground" />
                    </span>

                    <button
                        v-if="search"
                        class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                        @click="clearSearch"
                        tabindex="-1"
                        type="button"
                    >
                        <X class="size-5" />
                    </button>
                </div>
                <div class="flex gap-2 items-center">
                    <!-- <Label for="selection">Status Validasi:</Label> -->
                    <Select
                        v-model="selectedStatusPenerimaanBantuan"
                        @update:modelValue="applyFilter"
                        id="selection"
                    >
                        <SelectTrigger>
                            <SelectValue placeholder="Status Bantuan" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem> Semua </SelectItem>
                                <SelectItem value="diajukan">
                                    Diajukan
                                </SelectItem>
                                <SelectItem value="aktif"> Aktif </SelectItem>
                                <SelectItem value="selesai">
                                    Selesai
                                </SelectItem>
                                <SelectItem value="ditolak">
                                    Ditolak
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <Button asChild @click="resetFilter">
                        <div>
                            <FunnelX />
                            Reset
                        </div>
                    </Button>
                </div>
            </div>
            <div
                class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between"
            >
                <Button asChild>
                    <Link :href="route('penerima-bantuan.create')">
                        <PackagePlus /> Tambah Penerima Bantuan
                    </Link>
                </Button>
            </div>
        </div>
    </div>
    <div class="drop-shadow-md w-full grid gap-2">
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
    </div>
</template>
