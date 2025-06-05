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
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);

const search = ref(""); // Tambahan: input pencarian

const fetchData = async () => {
    try {
        items.value = [];
        isLoading.value = true;
        const res = await apiGet("/penerima-bantuan", {
            page: page.value,
            search: search.value,
        });
        items.value = res.data.data;
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data penerima bantuan");
    } finally {
        isLoading.value = false;
    }
};

onMounted(fetchData);
watch(page, fetchData);

// Saat user mengetik search, reset ke page 1 dan fetch ulang
watch(search, () => {
    page.value = 1;
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
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data Penerima Bantuan' },
                ]"
            />
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <Button asChild>
                <Link :href="route('kurang-mampu.create')">
                    + Penerima Bantuan
                </Link>
            </Button>
        </div>
    </div>

    <div class="drop-shadow-md w-full grid gap-2">
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between items-center"
        >
            <Input
                v-model="search"
                placeholder="Cari nama penduduk atau bantuan"
                class="md:w-1/3"
            />
        </div>

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
