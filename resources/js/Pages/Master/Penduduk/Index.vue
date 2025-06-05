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
import { SquarePlus } from "lucide-vue-next";

const items = ref([]);
const totalPages = ref(1);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);

// search input state
const search = ref("");

// filter object state
const filter = ref({
    status: "-",
    status_perkawinan: "-",
    pendidikan: "-",
    agama: "-",
});

const fetchData = async () => {
    try {
        items.value = [];
        isLoading.value = true;

        // Jika filter value adalah "-", ganti jadi string kosong agar query API tidak memasukkan filter tersebut
        const status = filter.value.status === "-" ? "" : filter.value.status;
        const status_perkawinan =
            filter.value.status_perkawinan === "-"
                ? ""
                : filter.value.status_perkawinan;
        const pendidikan =
            filter.value.pendidikan === "-" ? "" : filter.value.pendidikan;
        const agama = filter.value.agama === "-" ? "" : filter.value.agama;

        const res = await apiGet("/penduduk", {
            page: page.value,
            search: search.value,
            status,
            status_perkawinan,
            pendidikan,
            agama,
        });

        items.value = res.data.data;
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data penduduk");
    } finally {
        isLoading.value = false;
    }
};

// Reload data saat page berubah
watch(page, fetchData);

// Reload data saat search berubah, reset page ke 1
watch(search, () => {
    page.value = 1;
    fetchData();
});

// Reload data saat filter berubah, reset page ke 1
watch(filter, () => {
    page.value = 1;
    fetchData();
});

onMounted(fetchData);
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
        <div class="flex flex-wrap gap-4 items-center">
            <Button asChild>
                <router-link :to="{ name: 'penduduk.create' }">
                    <SquarePlus /> Penduduk
                </router-link>
            </Button>
        </div>
    </div>

    <div class="drop-shadow-md w-full grid gap-2">
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between"
        >
            <Input
                v-model="search"
                placeholder="Cari penduduk berdasarkan nama"
                class="md:w-1/3"
            />
            <div class="flex gap-4">
                <Select v-model="filter.status">
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
                <Select v-model="filter.status_perkawinan">
                    <SelectTrigger>
                        <SelectValue placeholder="Status Perkawinan" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Status Perkawinan</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem value="belum kawin"> Belum Kawin </SelectItem>
                            <SelectItem value="kawin"> Kawin </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select v-model="filter.pendidikan">
                    <SelectTrigger>
                        <SelectValue placeholder="Pendidikan" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Pendidikan</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem value="tidak sekolah"> Tidak Sekolah </SelectItem>
                            <SelectItem value="SD"> SD </SelectItem>
                            <SelectItem value="SMP"> SMP </SelectItem>
                            <SelectItem value="SMA"> SMA </SelectItem>
                            <SelectItem value="SMK"> SMK </SelectItem>
                            <SelectItem value="D3"> D3 </SelectItem>
                            <SelectItem value="D4"> D4 </SelectItem>
                            <SelectItem value="S1"> S1 </SelectItem>
                            <SelectItem value="S2"> S2 </SelectItem>
                            <SelectItem value="S3"> S3 </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select v-model="filter.agama">
                    <SelectTrigger>
                        <SelectValue placeholder="Agama" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Agama</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem value="islam"> Islam </SelectItem>
                            <SelectItem value="kristen"> Kristen </SelectItem>
                            <SelectItem value="katolik"> Katolik </SelectItem>
                            <SelectItem value="hindu"> Hindu </SelectItem>
                            <SelectItem value="budha"> Budha </SelectItem>
                            <SelectItem value="khonghucu"> Khonghucu </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>

                <Button @click="fetchData">Terapkan</Button>
            </div>
        </div>

        <DataTable
            label="Penduduk"
            :items="items"
            :columns="columnsIndex"
            :actions="actionsIndex"
            :totalPages="totalPages"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            :is-exportable="true"
            export-route="penduduk"
            @update:page="page = $event"
        />
    </div>
</template>
