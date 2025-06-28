<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { Button } from "@/components/ui/button";
import { SquarePen, Trash2 } from "lucide-vue-next";
import Badge from "@/components/ui/badge/Badge.vue";
import { rowsIndexBantuan } from "./utils/table";
import { onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { useBantuan } from "@/composables/useBantuan";
import AlertDialog from "@/components/master/AlertDialog.vue";

const { uuid } = usePage().props;

const selectedUuid = ref(null);
const isEditStatusBantuanDialogOpen = ref(false);
const isAlertDeleteOpen = ref(false);

const { item, fetchDetailBantuan, editStatusBantuan, deleteBantuan } =
    useBantuan();

//! Handle Delete
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
        await deleteBantuan(selectedUuid.value);
        isAlertDeleteOpen.value = false;
        selectedUuid.value = null;
    }
};

//! Handle Edit Status
const onClickEditStatusButton = (uuid) => {
    selectedUuid.value = uuid;
    isEditStatusBantuanDialogOpen.value = true;
};

const onCancelEditStatus = () => {
    isEditStatusBantuanDialogOpen.value = false;
    selectedUuid.value = null;
};

const onConfirmEditStatus = async () => {
    if (selectedUuid.value) {
        const status = item.value.status === "aktif" ? "nonaktif" : "aktif";
        await editStatusBantuan(selectedUuid.value, status);
        isEditStatusBantuanDialogOpen.value = false;
        selectedUuid.value = null;
        fetchDetailBantuan(uuid);
        if (status === "aktif") {
            labelButtonStatus.value = "Nonaktifkan Bantuan";
        } else {
            labelButtonStatus.value = "Aktifkan Bantuan";
        }
    }
};

const labelButtonStatus = ref("");

onMounted(async () => {
    await fetchDetailBantuan(uuid);
    if (item.value.status === "aktif") {
        labelButtonStatus.value = "Nonaktifkan Bantuan";
    } else {
        labelButtonStatus.value = "Aktifkan Bantuan";
    }
    // console.log(item.value);
});
</script>

<template>
    <Head title=" | Detail Bantuan" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Detail Bantuan</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Data Bantuan', href: '/admin/bantuan' },
                    { label: 'Detail Bantuan' },
                ]"
            />
        </div>
    </div>
    <div
        class="shadow-md p-4 rounded-lg flex flex-col lg:flex-row gap-4 justify-between"
    >
        <div class="w-full">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">
                    Detail Data
                    <Badge variant="outline">
                        {{
                            item.status
                                ? item.status
                                      .toLowerCase()
                                      .replace(/\b\w/g, (c) => c.toUpperCase())
                                : ""
                        }}
                    </Badge>
                </h2>

                <Button @click="onClickEditStatusButton(uuid)">
                    <SquarePen />
                    {{ labelButtonStatus }}
                </Button>
            </div>
            <table class="w-full table-auto border-collapse">
                <tbody>
                    <tr
                        v-for="row in rowsIndexBantuan"
                        :key="row.key"
                        class="even:bg-card/30"
                    >
                        <td class="font-medium p-2 align-top w-1/3">
                            {{ row.label }}
                        </td>
                        <td class="p-2">
                            {{
                                row.format
                                    ? row.format(item[row.key], item)
                                    : item[row.key] ?? "-"
                            }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="flex flex-col mt-2 gap-2">
                <div class="flex justify-between items-end w-full">
                    <p class="text-sm text-gray-500 mt-2">
                        <em
                            >*Batuan yang sudah pernah disalurkan tidak dapat
                            dihapus atau diubah.</em
                        >
                        <br />
                        <em
                            >*Hanya bantuan dengan status
                            <span class="font-semibold text-primary"
                                >aktif</span
                            >
                            yang bisa disalurkan kepada penduduk kurang
                            mampu.</em
                        >
                        <br />
                        <em
                            >*Hanya batuan dengan status
                            <span class="font-semibold text-primary"
                                >nonaktif</span
                            >
                            dan
                            <span class="font-semibold text-primary"
                                >belum pernah disalurkan</span
                            >
                            yang dapat diubah atau dihapus.
                        </em>
                    </p>
                    <div class="flex gap-2">
                        <Button
                            asChild
                            :hidden="
                                item.status === 'aktif' ||
                                item.penerima_bantuan_count > 0
                            "
                        >
                            <Link :href="route('bantuan.edit', uuid)">
                                <SquarePen /> Ubah Data
                            </Link>
                        </Button>
                        <Button
                            @click="onClickDeleteButton(uuid)"
                            :hidden="item.penerima_bantuan_count > 0"
                        >
                            <Trash2 /> Hapus
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div
        class="shadow-md p-2 rounded-lg flex flex-col lg:flex-row gap-2 justify-between"
    >
        <div class="w-full">
            <h2 class="text-lg font-bold p-2">
                Detail Data {{ item.nama_bantuan }}
            </h2>
            <table class="w-full gap-2 table">
                <tr
                    v-for="row in rowsIndexBantuan.slice(0, -3)"
                    :key="row.key"
                    class="even:bg-card/30 p-2"
                >
                    <td class="font-medium p-2">
                        {{ row.label }}
                    </td>
                    <td>
                        {{
                            row.format
                                ? row.format(item[row.key], item)
                                : item[row.key]
                        }}
                    </td>
                </tr>
            </table>
        </div>
    </div> -->
    <AlertDialog
        v-model:isOpen="isEditStatusBantuanDialogOpen"
        :title="labelButtonStatus"
        :description="'Apakah anda yakin ingin mengubah status bantuan ini?'"
        :onConfirm="onConfirmEditStatus"
        :onCancel="onCancelEditStatus"
    />
    <AlertDialog
        v-model:isOpen="isAlertDeleteOpen"
        :title="'Hapus Data Bantuan'"
        :description="'Apakah anda yakin ingin menghapus data bantuan ini?'"
        :onConfirm="onConfirmDelete"
        :onCancel="onCancelDelete"
    />
</template>
