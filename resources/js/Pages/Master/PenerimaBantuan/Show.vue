<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import Button from "@/components/ui/button/Button.vue";
import Badge from "@/components/ui/badge/Badge.vue";
import DataTable from "@/components/master/DataTable.vue";

import {
    rowsShow,
    columnsIndexPencairan,
    actionShowPencairan,
} from "./utils/table";
import EditStatusPenerimaBantuanDialog from "./components/EditStatusPenerimaBantuanDialog.vue";
import EditStatusPencairanDialog from "./components/EditStatusPencairanDialog.vue";
import CreatePencairanDialog from "./components/CreatePencairanDialog.vue";
import { onMounted, ref, computed, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { usePenerimaBantuan } from "@/composables/usePenerimaBantuan";
import { usePencairanBantuan } from "@/composables/usePencairanBantuan";
import AlertDialog from "@/components/master/AlertDialog.vue";

import {
    PackagePlus,
    SearchIcon,
    Eye,
    Trash2,
    PackageSearch,
    X,
    FunnelX,
    SquarePen,
} from "lucide-vue-next";

const { uuid } = usePage().props;

const {
    item: itemPenerimaBantuan,
    imageUrl,
    fetchDetailData: fetchDetailPenerimaBantuan,
    // editStatusBantuan,
    // editDetailData,
    deleteData: deleteDataPenerimaBantuan,
} = usePenerimaBantuan();

const {
    items,
    item,
    isLoading,
    page,
    perPage,
    totalPages,
    totalItems,
    fetchData: fetchDataPencairan,
    deleteData,
} = usePencairanBantuan();

const isEditStatusPenerimaBantuanDialogOpen = ref(false, itemPenerimaBantuan);
const isEditStatusPencairanDialogOpen = ref(false, item);
const isPencairanDialogOpen = ref(false);

//! Handle Delete Penerima
const selectedUuidPenerima = ref(null);
const isAlertDeletePenerimaOpen = ref(false);

const onClickDeletePenerimaButton = (uuid) => {
    selectedUuidPenerima.value = uuid;
    isAlertDeletePenerimaOpen.value = true;
};
const onCancelDeletePenerima = () => {
    isAlertDeletePenerimaOpen.value = false;
    selectedUuidPenerima.value = null;
};
const onConfirmDeletePenerima = async () => {
    if (selectedUuidPenerima.value) {
        await deleteDataPenerimaBantuan(selectedUuidPenerima.value);
        // isAlertDeletePenerimaOpen.value = false;
        // selectedUuidPenerima.value = null;
    }
};

//! Handle Delete Riwayat
const selectedUuidRiwayat = ref(null);
const isAlertDeleteRiwayatOpen = ref(false);

const onClickDeleteRiwayatButton = (uuid) => {
    selectedUuidRiwayat.value = uuid;
    isAlertDeleteRiwayatOpen.value = true;
};
const onCancelDeleteRiwayat = () => {
    isAlertDeleteRiwayatOpen.value = false;
    selectedUuidRiwayat.value = null;
};
const onConfirmDeleteRiwayat = async () => {
    if (selectedUuidRiwayat.value) {
        await deleteData(selectedUuidRiwayat.value);
        await fetchDataPencairan(idPenerimaBantuan.value);
        isAlertDeleteRiwayatOpen.value = false;
        selectedUuidRiwayat.value = null;
    }
};

const selectedPencairan = ref({});
const idPenerimaBantuan = ref(null);

const onClickChangeStatusPencairan = (item) => {
    selectedPencairan.value = item;
    isEditStatusPencairanDialogOpen.value = true;
};

// Setting Action Buttons Pencairan
const actionPencairan = actionShowPencairan(
    onClickDeleteRiwayatButton,
    onClickChangeStatusPencairan
);

onMounted(async () => {
    await fetchDetailPenerimaBantuan(uuid);
    if (itemPenerimaBantuan.value && itemPenerimaBantuan.value.id) {
        idPenerimaBantuan.value = itemPenerimaBantuan.value.id;
        fetchDataPencairan(idPenerimaBantuan.value);
    }
});

watch(page, () => {
    if (idPenerimaBantuan.value) {
        fetchDataPencairan(idPenerimaBantuan.value);
    }
});
</script>

<template>
    <Head title=" | Detail Penerima Bantuan" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Penerima Bantuan</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    {
                        label: 'Data Penerima Bantuan',
                        href: '/admin/penerima-bantuan',
                    },
                    { label: 'Detail Penerima Bantuan' },
                ]"
            />
        </div>
        <!-- <div class="flex gap-2 items-center">
            <Button asChild>
                <Link :href="route('penduduk.edit', uuid)">
                    <SquarePen /> Ubah
                </Link>
            </Button>
            <Button @click="onClickDeleteButton(uuid)">
                <Trash2 /> Hapus
            </Button>
        </div> -->
    </div>

    <div class="shadow-md p-2 rounded-lg flex my-4">
        <div class="w-full">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold p-2">
                    Detail Penerima Bantuan
                    <Badge variant="outline">
                        {{
                            itemPenerimaBantuan.status
                                ? itemPenerimaBantuan.status
                                      .toLowerCase()
                                      .replace(/\b\w/g, (c) => c.toUpperCase())
                                : ""
                        }}
                    </Badge>
                </h2>
                <div class="flex gap-2">
                    <!-- ! Edit Status Penerima Bantuan -->
                    <Button
                        @click="isEditStatusPenerimaBantuanDialogOpen = true"
                        variant="secondary"
                    >
                        <!-- <Button
                        @click="isEditStatusPenerimaBantuanDialogOpen = true"
                        variant="secondary"
                        :disabled="
                            itemPenerimaBantuan.bantuan &&
                            itemPenerimaBantuan.bantuan.status === 'nonaktif'
                        "
                    > -->
                        <SquarePen />
                        Ubah Status
                    </Button>
                    <Button
                        :disabled="
                            itemPenerimaBantuan.status ===
                                ('Aktif' || 'aktif') ||
                            itemPenerimaBantuan.riwayat_bantuan_count > 0
                        "
                        @click="onClickDeletePenerimaButton(uuid)"
                    >
                        <Trash2 />
                        Hapus
                    </Button>
                </div>
            </div>

            <table class="w-full gap-2 table">
                <tr
                    v-for="row in rowsShow"
                    :key="row.key"
                    class="even:bg-card/30 p-2"
                >
                    <td class="font-medium p-2">
                        {{ row.label }}
                    </td>
                    <td>
                        {{
                            row.format
                                ? row.format(
                                      itemPenerimaBantuan[row.key],
                                      itemPenerimaBantuan
                                  )
                                : itemPenerimaBantuan[row.key]
                        }}
                    </td>
                </tr>
            </table>
            <p class="text-sm text-gray-500 mt-2">
                <em
                    >*Jika status bantuan nonaktif, perubahan data atau
                    pencairan tidak bisa dilakukan.</em
                >
                <br />
                <em
                    >**Pencairan bantuan hanya dapat dilakukan jika status
                    penerima adalah aktif dan status bantuan juga aktif.</em
                >
            </p>
        </div>
    </div>

    <div class="shadow-md p-2 rounded-lg flex my-4">
        <!-- <div class="shadow-md p-2 rounded-lg flex flex-row gap-2 w-full my-4"> -->
        <div class="w-full">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold p-2">Riwayat Pencairan Bantuan</h2>
                <div class="flex gap-2">
                    <!-- <Button
                        @click="isPencairanDialogOpen = true"
                        variant="secondary"
                        :disabled="itemPenerimaBantuan.status !== 'Aktif' || itemPenerimaBantuan.status !== 'aktif'"
                    > -->
                    <Button
                        @click="isPencairanDialogOpen = true"
                        variant="secondary"
                        :disabled="
                            itemPenerimaBantuan.status !== 'Aktif' ||
                            (itemPenerimaBantuan.bantuan &&
                                itemPenerimaBantuan.bantuan.status !== 'aktif')
                        "
                    >
                        Cairkan Bantuan
                        <PackagePlus />
                    </Button>
                </div>
            </div>
            <div class="w-full grid gap-2">
                <DataTable
                    :items="items"
                    :columns="columnsIndexPencairan"
                    :actions="actionPencairan"
                    :totalPages="totalPages"
                    :totalData="totalItems"
                    :page="page"
                    :per-page="perPage"
                    :is-loading="isLoading"
                    @update:page="page = $event"
                />
            </div>
        </div>
    </div>

    <EditStatusPenerimaBantuanDialog
        v-model:isOpen="isEditStatusPenerimaBantuanDialogOpen"
        :initial-data="itemPenerimaBantuan"
        @success="
            () => {
                fetchDetailPenerimaBantuan(uuid),
                    (isEditStatusPenerimaBantuanDialogOpen = false);
            }
        "
    />
    <EditStatusPencairanDialog
        v-model:isOpen="isEditStatusPencairanDialogOpen"
        :initial-data="selectedPencairan"
        @success="
            () => {
                isEditStatusPencairanDialogOpen = false;
                fetchDataPencairan(idPenerimaBantuan);
            }
        "
    />
    <AlertDialog
        v-model:isOpen="isAlertDeleteRiwayatOpen"
        title="Hapus Riwayat Pencairan Bantuan"
        description="Apakah anda yakin ingin menghapus?"
        :onConfirm="onConfirmDeleteRiwayat"
        :onCancel="onCancelDeleteRiwayat"
    />
    <AlertDialog
        v-model:isOpen="isAlertDeletePenerimaOpen"
        title="Hapus Penerima Bantuan"
        description="Apakah anda yakin ingin menghapus?"
        :onConfirm="onConfirmDeletePenerima"
        :onCancel="onCancelDeletePenerima"
    />
    <CreatePencairanDialog
        v-if="idPenerimaBantuan"
        v-model:isOpen="isPencairanDialogOpen"
        :penerima-bantuan-id="idPenerimaBantuan"
        @success="
            () => {
                isPencairanDialogOpen = false;
                fetchDataPencairan(idPenerimaBantuan);
            }
        "
    />
</template>
