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
import Label from "@/components/ui/label/Label.vue";

const user = ref(null);
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
    jenis_kelamin: "",
    domisili: "",
    rt: "",
    rw: "",
    pendidikan: "",
    pekerjaan: "",
    agama: "",
    min_umur: "",
    max_umur: "",
});
const rtData = ref([]);
const rwData = ref([]);
const pendidikanData = ref([]);
const pekerjaanData = ref([]);

const fetchData = async () => {
    // try {
    //     items.value = [];
    //     isLoading.value = true;


    //     // Kalau nilai filter '-' ubah jadi string kosong ''
    //     const status = filter.value.status === "-" ? "" : filter.value.status;
    //     const status_perkawinan =
    //         filter.value.status_perkawinan === "-"
    //             ? ""
    //             : filter.value.status_perkawinan;
    //     const jenis_kelamin =
    //         filter.value.jenis_kelamin === "-"
    //             ? ""
    //             : filter.value.jenis_kelamin;
    //     const domisili =
    //         filter.value.domisili === "-" ? "" : filter.value.domisili;
    //     const rt = filter.value.rt === "-" ? "" : filter.value.rt;
    //     const rw = filter.value.rw === "-" ? "" : filter.value.rw;
    //     const pekerjaan =
    //         filter.value.pekerjaan === "-" ? "" : filter.value.pekerjaan;
    //     const pendidikan =
    //         filter.value.pendidikan === "-" ? "" : filter.value.pendidikan;
    //     const agama = filter.value.agama === "-" ? "" : filter.value.agama;
    //     const min_umur = filter.value.min_umur
    //         ? parseInt(filter.value.min_umur)
    //         : "";
    //     const max_umur = filter.value.max_umur
    //         ? parseInt(filter.value.max_umur)
    //         : "";

    //     const res = await apiGet("/penduduk", {
    //         page: page.value,
    //         search: searchPenduduk.value,
    //         status,
    //         status_perkawinan,
    //         pendidikan,
    //         agama,
    //         jenis_kelamin,
    //         domisili,
    //         rt,
    //         rw,
    //         pekerjaan,
    //         min_umur,
    //         max_umur,
    //     });

    //     items.value = res.data.data;
    //     perPage.value = res.data.per_page;
    //     totalPages.value = res.data.last_page;
    //     totalData.value = res.data.total;
    // } catch (error) {
    //     useErrorHandler(error, "Gagal memuat data penduduk");
    // } finally {
    //     isLoading.value = false;
    // }
    try {
        items.value = [];
        isLoading.value = true;

        // Ambil filter RT dari user jika role RT
        let rt = filter.value.rt === "-" ? "" : filter.value.rt;
        if (user.value?.role === "rt" && user.value?.perangkat_desa?.nomor_rt) {
            rt = user.value.perangkat_desa.nomor_rt;
        }

        let rw = filter.value.rw === "-" ? "" : filter.value.rw;
        if (user.value?.role === "rw" && user.value?.perangkat_desa?.nomor_rw) {
            rw = user.value.perangkat_desa.nomor_rw;
        }

        // ...filter lain...
        const res = await apiGet("/penduduk", {
            page: page.value,
            search: searchPenduduk.value,
            status: filter.value.status === "-" ? "" : filter.value.status,
            status_perkawinan: filter.value.status_perkawinan === "-" ? "" : filter.value.status_perkawinan,
            pendidikan: filter.value.pendidikan === "-" ? "" : filter.value.pendidikan,
            agama: filter.value.agama === "-" ? "" : filter.value.agama,
            jenis_kelamin: filter.value.jenis_kelamin === "-" ? "" : filter.value.jenis_kelamin,
            domisili: filter.value.domisili === "-" ? "" : filter.value.domisili,
            rt, // <-- gunakan hasil di atas
            rw,
            pekerjaan: filter.value.pekerjaan === "-" ? "" : filter.value.pekerjaan,
            min_umur: filter.value.min_umur ? parseInt(filter.value.min_umur) : "",
            max_umur: filter.value.max_umur ? parseInt(filter.value.max_umur) : "",
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
        jenis_kelamin: "",
        domisili: "",
        rt: "",
        rw: "",
        pekerjaan: "",
        min_umur: "",
        max_umur: "",
    };
    fetchData();
};

onMounted(async () => {
    try {
        isLoading.value = true;
        const res = await apiGet("/auth/me");
        user.value = res.data;
        // Fetch RT and RW data
        const [rtRes, rwRes, pendidikanRes, pekerjaanRes] = await Promise.all([
            apiGet("/rt"),
            apiGet("/rw"),
            apiGet("/pendidikan"),
            apiGet("/pekerjaan"),
        ]);

        rtData.value = rtRes.data.data;
        rwData.value = rwRes.data.data;
        pendidikanData.value = pendidikanRes.data.data;
        pekerjaanData.value = pekerjaanRes.data.data;

        // Fetch initial data
        await fetchData();
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data penduduk");
    } finally {
        isLoading.value = false;
    }
});
watch(page, fetchData);
</script>

<template>

    <Head title=" | Data Penduduk" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Penduduk</h1>
            <BreadcrumbComponent :items="[
                { label: 'Dashboard', href: '/admin/dashboard' },
                { label: 'Data Penduduk' },
            ]" />
        </div>
        <Button v-if="['admin', 'superadmin'].includes(user?.role)" asChild>
            <Link :href="route('penduduk.create')">
            <SquarePlus /> Penduduk
            </Link>
        </Button>
    </div>
    <div class="drop-shadow-md w-full grid gap-2">
        <div class="flex flex-wrap gap-2 justify-between">
            <div
                class="flex bg-primary-foreground relative items-center p-2 rounded-lg justify-between w-full xl:w-1/2">
                <Input v-model="searchPenduduk" @keyup.enter="onSearchEnter"
                    placeholder="Cari data penduduk berdasarkan nama atau nik" class="pl-10 pr-8" />
                <span class="absolute start-2 inset-y-0 flex items-center justify-center px-2">
                    <SearchIcon class="size-6 text-muted-foreground" />
                </span>
                <button v-if="searchPenduduk" @click="clearSearchPenduduk"
                    class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                    title="Hapus pencarian">
                    <XIcon />
                </button>
            </div>
            <div class="lg:max-w-10/12 flex flex-wrap gap-2 bg-primary-foreground p-2 rounded-lg">
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
                <Select v-model="filter.jenis_kelamin">
                    <SelectTrigger>
                        <SelectValue placeholder="Jenis Kelamin" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Jenis Kelamin</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem value="L"> Laki-Laki </SelectItem>
                            <SelectItem value="P"> Perempuan </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select v-model="filter.domisili">
                    <SelectTrigger>
                        <SelectValue placeholder="Domisili" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Domisili</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem value="tetap"> Tetap </SelectItem>
                            <SelectItem value="sementara">
                                Sementara
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select v-model="filter.rt" :disabled="user?.role === 'rt'">
                    <SelectTrigger>
                        <SelectValue placeholder="Nomor RT" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Nomor RT</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem v-for="rt in rtData" :key="rt.id" :value="rt.nomor_rt">
                                {{ rt.nomor_rt }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select v-model="filter.rw" :disabled="user?.role === 'rt' || user?.role === 'rw'">
                    <SelectTrigger>
                        <SelectValue placeholder="Nomor RW" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Nomor RW</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem v-for="rw in rwData" :key="rw.id" :value="rw.nomor_rw">
                                {{ rw.nomor_rw }}
                            </SelectItem>
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
                <Select v-model="filter.pendidikan">
                    <SelectTrigger>
                        <SelectValue placeholder="Pendidikan" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Pendidikan</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem v-for="pendidikan in pendidikanData" :key="pendidikan.id"
                                :value="pendidikan.jenjang">
                                {{ pendidikan.jenjang }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select v-model="filter.pekerjaan">
                    <SelectTrigger>
                        <SelectValue placeholder="Pekerjaan" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Pekerjaan</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem v-for="pekerjaan in pekerjaanData" :key="pekerjaan.id"
                                :value="pekerjaan.nama_pekerjaan">
                                {{ pekerjaan.nama_pekerjaan }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <div class="flex gap-2 border border-gray-200 pl-2 rounded-md">
                    <Label class="text-right">Filter Umur</Label>
                    <Input v-model="filter.min_umur" placeholder="Min" class="w-20" type="number" />
                    <Input v-model="filter.max_umur" placeholder="Max" class="w-20" type="number" />
                </div>
            </div>
            <div class="w-auto grid gap-2 bg-primary-foreground p-2 rounded-lg">
                <Button asChild @click="fetchData">
                    <div>
                        <Funnel />
                        Terapkan Filter
                    </div>
                </Button>
                <Button @click="resetFilter">
                    <FunnelX />
                    Reset Filter
                </Button>
            </div>
        </div>

        <DataTable label="Penduduk" :items="items" :columns="columnsIndex" :actions="actionsIndex"
            :totalPages="totalPages" :totalData="totalData" :page="page" :per-page="perPage" :is-loading="isLoading"
            :is-exportable="true" :export-route="'penduduk'" @update:page="page = $event" />
    </div>
</template>
