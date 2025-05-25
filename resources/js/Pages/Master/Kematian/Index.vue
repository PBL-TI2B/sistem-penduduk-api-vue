<script setup>
import { route } from "ziggy-js";
import { ref, onMounted, watch } from "vue";
import { apiGet } from "@/utils/api";
import { actionsIndex, columnsIndex, rowsShow } from "./utils/table";

import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import DataTable from "@/components/master/DataTable.vue";
import { useErrorHandler } from "@/composables/useErrorHandler";

const items = ref([]);
const totalPages = ref(1);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);

const search = ref("");

const fetchData = async () => {
    try {
        isLoading.value = true;
        const res = await apiGet("/kematian", {
            page: page.value,
            search: search.value,
        });
        items.value = res.data.data.map((item) => ({
            ...item,
            nama_penduduk: item.penduduk?.nama_lengkap || "-",
        }));
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data kematian");
    } finally {
        isLoading.value = false;
    }
};

const clearSearch = () => {
    search.value = "";
    page.value = 1;
    fetchData();
};

onMounted(fetchData);
watch(page, fetchData);
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

    <!-- Search & Action Area -->
    <div class="drop-shadow-md w-full grid gap-2">
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between items-center"
        >
            <!-- Input + X button dalam satu wrapper -->
            <div class="relative md:w-1/3">
                <Input
                    v-model="search"
                    placeholder="Cari data kematian berdasarkan nama atau sebab"
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

            <div class="flex gap-4">
                <Button class="cursor-pointer" @click="fetchData"
                    >Terapkan</Button
                >
            </div>
        </div>

        <!-- Data Table -->
        <DataTable
            :items="items"
            :columns="columnsIndex"
            :actions="actionsIndex"
            :totalPages="totalPages"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            :export-route="'kematian'"
            @update:page="page = $event"
        />
    </div>
</template>
