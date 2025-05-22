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

const fetchData = async () => {
    try {
        isLoading.value = true;
        const res = await apiGet("/kematian", { page: page.value });
        items.value = res.data.data.map(item => ({
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

onMounted(fetchData);
watch(page, fetchData);
</script>

<template>
    <Head title=" | Data Kematian" />
    <div class="flex items-center justify-between py-3">
        <div>
            <h1 class="text-3xl font-bold">Data Kematian</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data Kematian' },
                ]"
            />
        </div>
        <Button asChild>
            <Link :href="route('kematian.create')">+ Kematian</Link>
        </Button>
    </div>
    <div class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between mb-2">
        <Input placeholder="Cari berdasarkan penduduk atau sebab" class="md:w-1/3" />
        <Button class="cursor-pointer">Terapkan</Button>
    </div>
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
</template>
