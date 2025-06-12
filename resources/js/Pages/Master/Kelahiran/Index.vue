<script setup>
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
} from "lucide-vue-next";
import { route } from "ziggy-js";
import { onMounted, ref } from "vue";
import { useKelahiran } from "@/composables/useKelahiran";
import { columnsIndexKelahiran } from "./utils/table";
import { router } from "@inertiajs/vue3";

import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import AlertDialog from "@/components/master/AlertDialog.vue";

const searchPenduduk = ref("");
const selectedUuid = ref(null);
const isAlertDeleteOpen = ref(false);

const {
    items,
    item,
    isLoading,
    page,
    perPage,
    totalPages,
    filter,
    totalItems,
    totalData,
    search,
    selectedStatusValidasi,
    statusValidasiOptions,
    fetchData,
    fetchDetailData,
    createData,
    editData,
    deleteData,
} = useKelahiran();

const actionsIndexKelahiran = [
    {
        label: "Penduduk",
        icon: Eye,
        handler: (item) => {
            router.visit(route("penduduk.show", item.penduduk.uuid));
        },
    },
    {
        label: "Ubah",
        icon: PenBox,
        class: "bg-yellow-500 hover:bg-yellow-600 text-white",
        handler: (item) => {
            router.visit(route("kelahiran.edit", item.uuid));
        },
    },
    {
        label: "Hapus",
        icon: Trash2,
        class: "bg-red-500 hover:bg-red-600 text-white",
        disabled: (item) => item.riwayat_bantuan_count > 0,
        handler: (item) => {
            onClickDeleteButton(item.uuid);
        },
    },
];

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
        waktu_kelahiran: "",
    };
    fetchData();
};

onMounted(() => {
    fetchData();
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
        <div class="flex flex-wrap gap-2 justify-between">
            <div
                class="flex bg-primary-foreground relative items-center p-2 rounded-lg justify-between w-1/2"
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
                class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between"
            >
                <Datepicker
                    locale="id"
                    :enable-time-picker="false"
                    :format="'dd MMMM yyyy'"
                />
                <Button @click="createKematian"> <Funnel /> Terapkan </Button>
            </div>
        </div>

        <DataTable
            label="Kelahiran"
            :items="items"
            :columns="columnsIndexKelahiran"
            :actions="actionsIndexKelahiran"
            :totalPages="totalPages"
            :totalData="totalData"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            @update:page="page = $event"
        />
    </div>
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
