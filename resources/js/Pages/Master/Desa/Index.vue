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
import { actionsIndex, columnsIndex } from "./utils/tableDesa";
import { actionsIndex2, columnsIndex2 } from "./utils/tableDusun";
import { useErrorHandler } from "@/composables/useErrorHandler";

// TABEL DESA
const items = ref([]);
const totalPages = ref(1);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);

const fetchData = async () => {
    try {
        items.value = [];
        isLoading.value = true;
        const res = await apiGet("/desa", { page: page.value });
        items.value = res.data.data;
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data desa");
    } finally {
        isLoading.value = false;
    }
};

onMounted(fetchData);
watch(page, fetchData);

// TABEL DUSUN
const items2 = ref([]);
const totalPages2 = ref(1);
const page2 = ref(1);
const perPage2 = ref(10);
const isLoading2 = ref(false);
const search2 = ref("");

const fetchData2 = async () => {
    try {
        items2.value = [];
        isLoading2.value = true;
        const res = await apiGet("/dusun", {
            page: page2.value,
            search: search2.value,
        });
        items2.value = res.data.data;
        perPage2.value = res.data.per_page;
        totalPages2.value = res.data.last_page;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data dusun");
    } finally {
        isLoading2.value = false;
    }
};

onMounted(fetchData2);
watch([page2, search2], fetchData2);
</script>

<template>
    <Head title=" | Data Desa & Dusun" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Desa & Dusun</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data desa' },
                ]"
            />
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <Button asChild>
                <Link> + Dusun</Link>
            </Button>
            <Button asChild>
                <Link :href="route('desa.create')"> + Desa</Link>
            </Button>
        </div>
    </div>

    <div class="drop-shadow-md w-full grid gap-2">
        <!-- TABEL DESA (tanpa filter) -->
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

        <!-- TABEL DUSUN -->
        <h2 class="text-2xl font-semibold mt-8">Data Dusun</h2>

        <!-- Search/filter khusus dusun -->
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between"
        >
            <Input
                v-model="search2"
                placeholder="Cari dusun berdasarkan nama"
                class="md:w-1/3"
            />
            <div class="flex gap-4">
                <Button class="cursor-pointer" @click="fetchData2"
                    >Terapkan</Button
                >
            </div>
        </div>

        <DataTable
            :items="items2"
            :columns="columnsIndex2"
            :actions="actionsIndex2"
            :totalPages="totalPages2"
            :page="page2"
            :per-page="perPage2"
            :is-loading="isLoading2"
            @update:page="page2 = $event"
        />
    </div>
</template>
