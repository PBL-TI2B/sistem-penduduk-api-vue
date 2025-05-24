<script setup>
import { route } from "ziggy-js";
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
import { actionsIndex, columnsIndex } from "./utils/table";
import { columnsJabatan } from "./utils/table";
import { PenBoxIcon, SquarePlus, Trash2 } from "lucide-vue-next";
import FormDialogJabatan from "./components/FormDialogJabatan.vue";
import { usePerangkatDesa } from "@/composables/usePerangkatDesa";
import { useJabatan } from "@/composables/useJabatan";
import AlertDialog from "@/components/master/AlertDialog.vue";

const isFormDialogOpen = ref(false);
const dialogMode = ref("create");
const selectedJabatan = ref(null);
const isAlertDeleteOpen = ref(false);
const selectedUuid = ref(null);

const { fetchPerangkatDesa, items, page, perPage, totalPages, isLoading } =
    usePerangkatDesa();

const {
    fetchJabatan,
    deleteJabatan,
    itemsJabatan,
    perPageJabatan,
    pageJabatan,
    totalPagesJabatan,
    isLoadingJabatan,
} = useJabatan();

const editJabatan = (jabatan) => {
    isFormDialogOpen.value = true;
    dialogMode.value = "edit";
    selectedJabatan.value = jabatan;
};

const createJabatan = () => {
    isFormDialogOpen.value = true;
    dialogMode.value = "create";
};

const actionsJabatan = [
    {
        label: "",
        icon: PenBoxIcon,
        handler: (item) => {
            editJabatan(item);
        },
    },
    {
        label: "",
        icon: Trash2,
        handler: (item) => {
            onClickDeleteButton(item.uuid);
        },
    },
];

const onClickDeleteButton = (uuid) => {
    selectedUuid.value = uuid;
    isAlertDeleteOpen.value = true;
};

const onCancleDelete = () => {
    isAlertDeleteOpen.value = false;
    selectedUuid.value = null;
};

const onConfirmDelete = async () => {
    if (selectedUuid.value) {
        await deleteJabatan(selectedUuid.value);
        isAlertDeleteOpen.value = false;
        selectedUuid.value = null;
    }
};

onMounted(() => {
    fetchPerangkatDesa();
    fetchJabatan();
});

watch(page, () => {
    fetchPerangkatDesa();
});

watch(pageJabatan, () => {
    fetchJabatan();
});
</script>

<template>
    <Head title=" | Data Perangkat Desa" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Perangkat Desa</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data Perangkat Desa' },
                ]"
            />
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <Button @click="createJabatan"> <SquarePlus /> Jabatan </Button>
            <Button asChild>
                <Link
                    :href="route('perangkat-desa.create')"
                    class="flex items-center gap-1"
                >
                    <SquarePlus /> Perangkat Desa
                </Link>
            </Button>
        </div>
    </div>
    <div class="drop-shadow-md w-full grid gap-2">
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between"
        >
            <Input
                v-model="search"
                placeholder="Cari perangkat desa berdasarkan nama"
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
                            <SelectItem value="aktif"> Aktif </SelectItem>
                            <SelectItem value="nonaktif"> Nonaktif </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select>
                    <SelectTrigger>
                        <SelectValue placeholder="Jabatan" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Jabatan</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem value="ketua"> Ketua RT </SelectItem>
                            <SelectItem value="ketua-rw"> Ketua RW </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Button class="cursor-pointer">Terapkan</Button>
            </div>
        </div>

        <DataTable
            label="Jabatan"
            :items="itemsJabatan"
            :columns="columnsJabatan"
            :actions="actionsJabatan"
            :totalPages="totalPagesJabatan"
            :page="pageJabatan"
            :per-page="perPageJabatan"
            :is-loading="isLoadingJabatan"
            @update:page="pageJabatan = $event"
        />

        <DataTable
            label="Perangkat Desa"
            :items="items"
            :columns="columnsIndex"
            :actions="actionsIndex"
            :totalPages="totalPages"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            :is-exportable="true"
            :export-route="'perangkat-desa'"
            @update:page="page = $event"
        />
    </div>
    <FormDialogJabatan
        v-model:isOpen="isFormDialogOpen"
        :mode="dialogMode"
        :initial-data="selectedJabatan"
        @success="fetchJabatan"
    />
    <AlertDialog
        v-model:isOpen="isAlertDeleteOpen"
        title="Hapus Jabatan"
        description="Apakah anda yakin ingin menghapus jabatan ini?"
        :onConfirm="onConfirmDelete"
        :onCancle="onCancleDelete"
    />
</template>
