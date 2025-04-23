<script setup>
import { route } from "ziggy-js";
import { router } from "@inertiajs/vue3";
import { ref, onMounted, watch } from "vue";

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
import { Eye, FileText, Sheet } from "lucide-vue-next";
import { apiGet } from "@/utils/api";

const items = ref([]);
const totalPages = ref(1);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);

const fetchData = async () => {
    try {
        items.value = [];
        isLoading.value = true;
        const res = await apiGet("/penduduk", { page: page.value });
        items.value = res.data.data;
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
    } catch (error) {
        console.error("Error fetching data:", error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(fetchData);
watch(page, fetchData);

const columns = [
    { label: "Nama Lengkap", key: "nama_lengkap" },
    {
        label: "Jenis Kelamin",
        key: "jenis_kelamin",
        format: (value) => {
            return value === "L" ? "Laki-laki" : "Perempuan";
        },
    },
    { label: "Tempat Lahir", key: "tempat_lahir" },
    { label: "Tanggal Lahir", key: "tanggal_lahir" },
    {
        label: "Pendidikan",
        key: "pendidikan",
        format: (val, row) => row.pendidikan?.jenjang || "-",
    },
    {
        label: "Pekerjaan",
        key: "pekerjaan",
        format: (val, row) => row.pekerjaan?.nama_pekerjaan || "-",
    },
    {
        label: "Status",
        key: "status",
    },
    {
        label: "Status Perkawinan",
        key: "status_perkawinan",
    },
];

const actions = [
    {
        label: "Manage",
        icon: Eye,
        handler: (item) => {
            router.visit(route("penduduk.show", item.uuid));
        },
    },
];
</script>

<template>
    <Head title=" | Data Penduduk" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Penduduk</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data Penduduk' },
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
                <Link :href="route('penduduk.create')">Tambah Data</Link>
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
                <Select>
                    <SelectTrigger>
                        <SelectValue placeholder="Status" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Status</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem value="hidup"> Hidup </SelectItem>
                            <SelectItem value="mati"> Mati </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select>
                    <SelectTrigger>
                        <SelectValue placeholder="Status Perkawinan" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Status Perkawinan</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem value="belum kawin">
                                Belum Kawin
                            </SelectItem>
                            <SelectItem value="kawin"> Kawin </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Button class="cursor-pointer">Terapkan</Button>
            </div>
        </div>
        <DataTable
            :items="items"
            :columns="columns"
            :actions="actions"
            :totalPages="totalPages"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            @update:page="page = $event"
        />
    </div>
</template>
