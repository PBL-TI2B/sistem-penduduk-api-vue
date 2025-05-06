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
import { FileText, Sheet } from "lucide-vue-next";

import DataTable from "@/components/master/DataTable.vue";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { actionsIndex, columnsIndex } from "./utils/table";
import { useErrorHandler } from "@/composables/useErrorHandler";

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
        useErrorHandler(error, "Gagal memuat data penduduk");
    } finally {
        isLoading.value = false;
    }
};

onMounted(fetchData);
watch(page, fetchData);
</script>

<template>
    <Head title=" | Data Desa" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Desa</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data Desa' },
                ]"
            />
        </div>
        <div class="flex gap-4 items-center">
            <Select>
                <SelectTrigger class="bg-primary-foreground">
                    <SelectValue placeholder="Export" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectLabel>Export Ke</SelectLabel>
                        <SelectItem value="pdf">
                            <FileText />
                            Pdf
                        </SelectItem>
                        <SelectItem value="excel"> <Sheet /> Excel </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
            <Button asChild>
                <Link :href="route('desa.create')"> + Desa</Link>
            </Button>
            <Button asChild>
                <Link :href="route('dusun.create')"> + Dusun</Link>
            </Button>
        </div>
    </div>
    <div class="w-full grid gap-2">
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between"
        >
            <Input
                v-model="search"
                placeholder="Cari penduduk berdasarkan nama"
                class="md:w-1/3"
            />
            <div class="flex gap-4">
                <Button class="cursor-pointer">Terapkan</Button>
            </div>
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
