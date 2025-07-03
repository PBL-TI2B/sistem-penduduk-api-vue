<script setup>
import { onMounted, ref, watch } from "vue";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import DataTable from "@/components/master/DataTable.vue";
import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import {
    Eye,
    PenBox,
    SearchIcon,
    SquarePlus,
    Trash2,
    XIcon,
    Funnel,
} from "lucide-vue-next";
import { route } from "ziggy-js";
import { useKelahiran } from "@/composables/useKelahiran";
import { columnsIndexKelahiran } from "./utils/table";
import { router } from "@inertiajs/vue3";
import AlertDialog from "@/components/master/AlertDialog.vue";

const selectedUuid = ref(null);
const isAlertDeleteOpen = ref(false);

const {
    items,
    item,
    isLoading,
    page,
    perPage,
    totalPages,
    totalData,
    search,
    filter,
    fetchData,
    fetchDetailData,
    createData,
    editData,
    deleteData,
} = useKelahiran();

const searchPenduduk = ref("");
watch(searchPenduduk, (val) => {
    search.value = val;
});

const onSearchEnter = (e) => {
    if (e.key === "Enter") {
        page.value = 1;
        fetchData();
    }
};

const clearSearchPenduduk = () => {
    searchPenduduk.value = "";
    search.value = "";
    page.value = 1;
    fetchData();
};

const onClickDeleteButton = (uuid) => {
    selectedUuid.value = uuid;
    isAlertDeleteOpen.value = true;
};
const onCancelDelete = () => {
    isAlertDeleteOpen.value = false;
    selectedUuid.value = null;
};
const onConfirmDelete = async () => {
    if (selectedUuid.value) {
        await deleteData(selectedUuid.value);
        isAlertDeleteOpen.value = false;
        selectedUuid.value = null;
    }
};

const resetFilter = () => {
    filter.value = {
        bulan: "",
        tahun: "",
        anak_ke: "",
        min_berat: "",
        max_berat: "",
        min_panjang: "",
        max_panjang: "",
    };
    selectedMonth.value = null;
    fetchData();
};

onMounted(() => {
    fetchData();
});

const selectedMonth = ref(null);
const selectedYear = ref(null);

// Daftar bulan (1–12)
const monthOptions = [
    { value: 1, label: "Januari" },
    { value: 2, label: "Februari" },
    { value: 3, label: "Maret" },
    { value: 4, label: "April" },
    { value: 5, label: "Mei" },
    { value: 6, label: "Juni" },
    { value: 7, label: "Juli" },
    { value: 8, label: "Agustus" },
    { value: 9, label: "September" },
    { value: 10, label: "Oktober" },
    { value: 11, label: "November" },
    { value: 12, label: "Desember" },
];

watch(selectedMonth, (val) => {
    filter.value.bulan = val;
});
</script>

<template>
    <Head title=" | Data Kelahiran" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Kelahiran</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Data Kelahiran' },
                ]"
            />
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <Button asChild>
                <Link
                    :href="route('kelahiran.create')"
                    class="flex items-center gap-1"
                >
                    <SquarePlus /> Kelahiran
                </Link>
            </Button>
        </div>
    </div>

    <div class="drop-shadow-md w-full grid gap-2">
        <!-- Search & Filter -->
        <div class="flex flex-wrap gap-2 justify-between">
            <!-- Search -->
            <div
                class="flex bg-primary-foreground relative items-center p-2 rounded-lg justify-between w-full xl:w-1/2"
            >
                <Input
                    v-model="searchPenduduk"
                    @keyup.enter="onSearchEnter"
                    placeholder="Cari Nama / Anak ke / Berat / Panjang / Lokasi / Keterangan"
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
                    class="absolute right-2 top-2.5 text-muted-foreground hover:text-primary"
                    title="Hapus pencarian"
                >
                    <XIcon class="size-6 text-muted-foreground" />
                </button>
            </div>

            <!-- Filter Inputs -->
            <div
                class="lg:max-w-10/12 flex flex-wrap gap-2 bg-primary-foreground p-2 rounded-lg"
            >
                <Input
                    v-model="filter.anak_ke"
                    placeholder="Anak ke-"
                    class="w-24"
                />

                <!-- Bulan & Tahun -->
                <div class="grid gap-2">
                    <select
                        v-model="selectedMonth"
                        class="border rounded-md px-3 py-2 w-30 h-9 text-sm text-muted-foreground"
                    >
                        <option :value="null" disabled>Pilih Bulan</option>
                        <option
                            v-for="month in monthOptions"
                            :key="month.value"
                            :value="month.value"
                        >
                            {{ month.label }}
                        </option>
                    </select>

                    <Input
                        v-model="filter.tahun"
                        placeholder="Tahun (2025)"
                        class="w-28"
                    />
                </div>
                <div class="grid gap-2">
                    <!-- Berat -->
                    <div class="flex gap-2">
                        <Input
                            v-model="filter.min_berat"
                            placeholder="Min Berat"
                            class="w-28"
                        />
                        <Input
                            v-model="filter.max_berat"
                            placeholder="Max Berat"
                            class="w-28"
                        />
                    </div>

                    <!-- Panjang -->
                    <div class="flex gap-2">
                        <Input
                            v-model="filter.min_panjang"
                            placeholder="Min Panjang"
                            class="w-28"
                        />
                        <Input
                            v-model="filter.max_panjang"
                            placeholder="Max Panjang"
                            class="w-28"
                        />
                    </div>
                </div>
                <!-- Buttons -->
                <div
                    class="w-auto grid gap-2 bg-primary-foreground p-2 rounded-lg"
                >
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
        </div>

        <!-- Table -->
        <DataTable
            label="Kelahiran"
            :items="items"
            :columns="columnsIndexKelahiran"
            :actions="[
                {
                    label: 'Penduduk',
                    icon: Eye,
                    handler: (item) =>
                        router.visit(
                            route('penduduk.show', item.penduduk.uuid)
                        ),
                },
                {
                    label: 'Ubah',
                    icon: PenBox,
                    class: 'bg-yellow-500 hover:bg-yellow-600 text-white',
                    handler: (item) =>
                        router.visit(route('kelahiran.edit', item.uuid)),
                },
                {
                    label: 'Hapus',
                    icon: Trash2,
                    class: 'bg-red-500 hover:bg-red-600 text-white',
                    disabled: (item) => item.riwayat_bantuan_count > 0,
                    handler: (item) => onClickDeleteButton(item.uuid),
                },
            ]"
            :totalPages="totalPages"
            :totalData="totalData"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            @update:page="page = $event"
        />
    </div>

    <!-- Hapus Dialog -->
    <AlertDialog
        v-model:isOpen="isAlertDeleteOpen"
        title="Hapus Kelahiran"
        description="Apakah anda yakin ingin menghapus?"
        :onConfirm="onConfirmDelete"
        :onCancel="onCancelDelete"
    />
</template>

<style scoped>
:deep(.dp__cell_inner.dp__active_date) {
    background-color: oklch(0.31 0.0702 152.07) !important; /* biru */
    color: white !important;
    border-radius: 6px;
}

:deep(.dp__cell_inner.dp__today) {
    border: 2px solid oklch(0.31 0.0702 152.07); /* border biru */
    border-radius: 6px;
}

:deep(.dp__action_button) {
    background-color: oklch(0.31 0.0702 152.07); /* warna latar */
    color: white; /* warna teks */
    border-radius: 6px;
    border: none;
}

:deep(.dp__action_button:hover) {
    background-color: oklch(0.22 0.0049 158.96); /* saat hover */
}
</style>
