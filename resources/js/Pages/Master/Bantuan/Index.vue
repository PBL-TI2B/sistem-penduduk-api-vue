<script setup>
import { route } from "ziggy-js";
import { PackagePlus } from 'lucide-vue-next';
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
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);
const search = ref(null);
const kategoriOptions = ref([]);
const selectedKategori = ref(null);

// Ambil data kategori dari endpoint
const fetchKategoriOptions = async () => {
    try {
        const res = await apiGet("/kategori-bantuan");
        // Asumsi data kategori ada di res.data.data
        kategoriOptions.value = [
            { value: "-", label: "Semua" },
            ...res.data.data.map(kat => ({
                value: kat.id,
                label: kat.kategori.charAt(0).toUpperCase() + kat.kategori.slice(1)
            }))
        ];
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data kategori");
    }
};

// Ambil data bantuan dengan filter search & kategori
const fetchData = async () => {
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
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data bantuan");
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    fetchKategoriOptions();
    fetchData();
});
watch(page, fetchData);

const applyFilter = () => {
    page.value = 1;
    fetchData();
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
        <div class="flex gap-4 items-center">
            <div
                class="flex flex-wrap bg-primary-foreground p-2 rounded-lg gap-2 justify-between w-full"
            >
                <Input
                    v-model="search"
                    placeholder="Cari bantuan"
                    class="md:w-3/5 "
                    @keyup.enter="applyFilter"
                />
                <div class="flex gap-2 items-center">
                    <Select v-model="selectedKategori">
                        <SelectTrigger>
                            <SelectValue placeholder="Kategori" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Kategori</SelectLabel>
                                <SelectItem
                                    v-for="kat in kategoriOptions"
                                    :key="kat.id"
                                    :value="kat.value"
                                >
                                    {{ kat.label }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <Button class="cursor-pointer" @click="applyFilter">Terapkan</Button>
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
        <!-- <div class="flex flex-wrap justify-end gap-4 items-center">

        </div> -->
        <DataTable
            label="Bantuan"
            :items="items"
            :columns="columnsIndex"
            :actions="actionsIndex"
            :totalPages="totalPages"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            :is-exportable="true"
            :export-route="'bantuan'"
            @update:page="page = $event"
        />
    </div>
</template>
