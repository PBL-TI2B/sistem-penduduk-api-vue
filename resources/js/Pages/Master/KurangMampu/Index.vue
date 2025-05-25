<script setup>
import { route } from "ziggy-js";
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

import DataTable from "@/components/master/DataTable.vue";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { actionsIndex, columnsIndex } from "./utils/table";
import { useErrorHandler } from "@/composables/useErrorHandler";

const items = ref([]);
const totalPages = ref(1);
const totalItems = ref(1);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);

const search = ref("");
const selectedKategori = ref("-");
const selectedStatusValidasi = ref("");
const statusValidasiOptions = ref([]);

const fetchStatusValidasiOptions = async () => {
    try {
        const res = await apiGet("/status-validasi-options");
        statusValidasiOptions.value = res.data;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat pilihan status validasi");
    }
};

const fetchData = async () => {
    try {
        items.value = [];
        isLoading.value = true;
        const res = await apiGet("/kurang-mampu", {
            page: page.value,
            search: search.value,
            status_validasi: selectedStatusValidasi.value,
        });
        items.value = res.data.data.map((item) => ({
            ...item,
            nama_penduduk: item.penduduk?.nama_lengkap || "-",
        }));
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
        totalItems.value = res.data.total;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data kurang mampu");
    } finally {
        isLoading.value = false;
    }
};

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
    selectedKategori.value = "-";
    selectedStatusValidasi.value = "";
    applyFilter();
};

onMounted(() => {
    fetchData();
    fetchStatusValidasiOptions();
});
watch(page, fetchData);
</script>

<template>
    <Head title=" | Data Kurang Mampu" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Kurang Mampu</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data kurang mampu' },
                ]"
            />
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <Button asChild>
                <Link :href="route('kurang-mampu.create')">
                    + Kurang Mampu
                </Link>
            </Button>
        </div>
    </div>

    <div class="drop-shadow-md w-full grid gap-2">
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap md:flex-nowrap justify-between items-center gap-2"
        >
            <div class="flex items-center gap-2 md:w-1/2 w-full">
                <div class="relative w-full">
                    <Input
                        v-model="search"
                        placeholder="Cari data kurang mampu berdasarkan nama"
                        class="w-full pr-8"
                    />
                    <button
                        v-if="search"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-primary"
                        @click="clearSearch"
                        tabindex="-1"
                        type="button"
                    >
                        ✕
                    </button>
                </div>
                <Button class="whitespace-nowrap" @click="fetchData">
                    Cari
                </Button>
            </div>

            <div class="flex flex-wrap items-center gap-2 justify-end">
                <Label for="kategori">Kategori:</Label>
                <Select
                    v-model="selectedKategori"
                    @update:modelValue="applyFilter"
                    id="kategori"
                >
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

                <Button asChild @click="resetFilter">
                    <div class="flex items-center gap-1"><FunnelX /> Reset</div>
                </Button>
            </div>
        </div>

        <DataTable
            :items="items"
            :columns="columnsIndex"
            :actions="actionsIndex"
            :totalPages="totalPages"
            :totalData="totalItems"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            @update:page="page = $event"
        />
    </div>
</template>
