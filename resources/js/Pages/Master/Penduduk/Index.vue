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
import {
    Funnel,
    FunnelX,
    SearchIcon,
    SquarePlus,
    XIcon,
} from "lucide-vue-next";

const items = ref([]);
const totalPages = ref(1);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);
const totalData = ref(0);
const searchPenduduk = ref("");
const filter = ref({
    status: "",
    status_perkawinan: "",
    pendidikan: "",
    agama: "",
});

const fetchData = async () => {
    try {
        items.value = [];
        isLoading.value = true;

        // Kalau nilai filter '-' ubah jadi string kosong ''
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
            search: searchPenduduk.value,
            status,
            status_perkawinan,
            pendidikan,
            agama,
        });

        items.value = res.data.data;
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
        totalData.value = res.data.total;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data penduduk");
    } finally {
        isLoading.value = false;
    }
};

const onSearchEnter = (e) => {
    if (e.key === "Enter") {
        page.value = 1;
        fetchData();
    }
};

const clearSearchPenduduk = () => {
    searchPenduduk.value = "";
    page.value = 1;
    fetchData();
};

const resetFilter = () => {
    filter.value = {
        status: "",
        status_perkawinan: "",
        pendidikan: "",
        agama: "",
    };
    fetchData();
};

onMounted(fetchData);
watch(page, fetchData);
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
                <Link :href="route('penduduk.create')">
                    <SquarePlus /> Penduduk</Link
                >
            </Button>
        </div>
    </div>
    <div class="drop-shadow-md w-full grid gap-2">
        <div class="flex flex-wrap gap-2 justify-between">
            <div
                class="flex bg-primary-foreground relative items-center p-2 rounded-lg justify-between w-full xl:w-[35%]"
            >
                <Input
                    v-model="searchPenduduk"
                    @keyup.enter="onSearchEnter"
                    placeholder="Cari data Penduduk"
                    class="pl-10 pr-8"
                />
                <span
                    class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
                >
                    <SearchIcon class="size-6 text-muted-foreground" />
                </span>
                <button
                    v-if="searchPenduduk"
                    @click="clearSearchPenduduk"
                    class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                    title="Hapus pencarian"
                >
                    <XIcon />
                </button>
            </div>
            <div
                class="flex flex-wrap gap-4 bg-primary-foreground p-2 rounded-lg"
            >
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
                            <SelectItem value="belum kawin">
                                Belum Kawin
                            </SelectItem>
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
                            <SelectItem value="tidak sekolah">
                                Tidak Sekolah
                            </SelectItem>
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
                            <SelectItem value="khonghucu">
                                Khonghucu
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
                <Button class="cursor-pointer" @click="fetchData">
                    <Funnel />
                    Terapkan</Button
                >
            </div>
        </div>
        <DataTable
            label="Penduduk"
            :items="items"
            :columns="columnsIndex"
            :actions="actionsIndex"
            :totalPages="totalPages"
            :totalData="totalData"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            :is-exportable="true"
            :export-route="'penduduk'"
            @update:page="page = $event"
        />
    </div>
</template>
