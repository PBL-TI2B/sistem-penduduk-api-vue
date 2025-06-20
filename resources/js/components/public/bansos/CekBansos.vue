<script setup>
import { onMounted, watch, ref } from "vue";
import { useBantuan } from "@/composables/useBantuan";
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
// import { Label } from "@/components/ui/label";
import DataTable from "@/components/master/DataTable.vue";
import { formatCurrency, formatDate } from "@/composables/formatData";
import { PackagePlus, SearchIcon, X, FunnelX, Eye } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import { route } from "ziggy-js";

const {
    items,
    isLoading,
    page,
    perPage,
    totalPages,
    totalData,
    search,
    selectedKategori,
    fetchBantuan,
} = useBantuan();

const isHidden = ref(true);

// Table Index
const columnsIndex = [
    { label: "Nama Bantuan", key: "nama_bantuan" },
    { label: "Kategori", key: "kategori" },
    { label: "Nominal", key: "nominal", format: formatCurrency },
    { label: "Periode", key: "periode" },
    { label: "Lama Periode", key: "lama_periode" },
    { label: "Instansi", key: "instansi" },
    { label: "Jumlah Penerima", key: "penerima_bantuan_count" },
    // {
    //     label: "Keterangan",
    //     key: "keterangan",
    //     format: (value) => {
    //         return value ?? "-";
    //     },
    // },
];

// Actions Index
const actionsIndex = [
    {
        label: "Lihat Bantuan",
        icon: Eye,
        // handler: (item) => {
        // router.visit(route("bantuan.show", item.uuid));
        // },
    },
];

//  -- Filter Bantuan --
const applyFilter = () => {
    page.value = 1;
    fetchBantuan();
};
const resetFilter = () => {
    search.value = "";
    selectedKategori.value = "";
    applyFilter();
};

const clearSearchBantuan = () => {
    search.value = "";
    isHidden.value = true;
    applyFilter();
};

// onMounted(async () => {
//     await fetchBantuan();
// });

watch(page, () => {
    fetchBantuan();
});
</script>

<template>
    <section class="bg-gray shadow-md rounded-xl p-6 mt-4">
        <!-- Input Cek Bansos-->
        <div
            class="flex items-center gap-2 bg-[#e7fcee] text-green-700 font-semibold px-4 py-2 rounded-full w-fit mb-4"
        >
            <div class="w-1 h-6 bg-green-500 rounded"></div>
            <div
                class="flex items-center gap-2 text-xl font-bold text-[#233D34]"
            >
                <span>Cari Informasi Bansos</span>
            </div>
        </div>
        <!-- Search Bantuan -->
        <div
            class="overflow-x-auto shadow-sm hover:drop-shadow-lg flex flex-col xl:flex-row items-center gap-4 w-full"
        >
            <div
                class="flex items-center justify-between w-full bg-primary-foreground p-2 rounded-lg gap-2"
            >
                <div class="flex items-center relative w-full">
                    <Input
                        id="search"
                        v-model="search"
                        type="text"
                        placeholder="Cari bantuan"
                        class="pl-10 pr-8"
                        @change="
                            () => {
                                if (search == '') {
                                    isHidden = true;
                                } else {
                                    isHidden = false;
                                }
                                applyFilter();
                            }
                        "
                    />
                    <span
                        class="absolute inset-y-0 start-0 flex items-center justify-center px-2"
                    >
                        <SearchIcon class="size-6 text-muted-foreground" />
                    </span>
                    <button
                        v-if="search"
                        class="absolute inset-y-0 end-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                        @click="clearSearchBantuan"
                        tabindex="-1"
                        type="button"
                    >
                        <X class="size-5" />
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section>
        <!-- Tabel Informasi Bansos -->
        <div
            class="overflow-x-auto mt-4 mb-10 shadow-sm hover:drop-shadow-lg"
            :hidden="isHidden"
        >
            <DataTable
                label="Bantuan"
                :items="items"
                :columns="columnsIndex"
                :actions="actionsIndex"
                :totalPages="totalPages"
                :totalData="totalData"
                :page="page"
                :per-page="perPage"
                :is-loading="isLoading"
                @update:page="page = $event"
            />
        </div>
    </section>
</template>
