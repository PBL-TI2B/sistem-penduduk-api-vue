<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import Button from "@/components/ui/button/Button.vue";
import Badge from "@/components/ui/badge/Badge.vue";
import DataTable from "@/components/master/DataTable.vue";

import { rowsShow, columnsIndexPencairan, actionsIndex } from "./utils/table";
import EditStatusBantuanDialog from "./components/EditStatusBantuanDialog.vue";
import EditStatusPencairanDialog from "./components/EditStatusPencairanDialog.vue";
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
    // editStatusBantuan,
    // editDetailData,
} = usePencairanBantuan();

const isEditStatusBantuanDialogOpen = ref(false, itemPenerimaBantuan);
// const isEditStatusPencairanDialogOpen = ref(false, item);

onMounted(async () => {
    await fetchDetailPenerimaBantuan(uuid);
    if (itemPenerimaBantuan.value && itemPenerimaBantuan.value.id) {
        fetchDataPencairan(itemPenerimaBantuan.value.id);
    }
});

watch(page, fetchDataPencairan(itemPenerimaBantuan.value.id));
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
                        {{ itemPenerimaBantuan.status }}
                    </Badge>
                </h2>
                <div class="flex gap-2">
                    <Button
                        @click="isEditStatusBantuanDialogOpen = true"
                        variant="secondary"
                    >
                        Ubah Status Bantuan
                        <SquarePen />
                    </Button>
                    <!-- <Button
                        @click="isEditStatusPencairanDialogOpen = true"
                        variant="secondary"
                    >
                        Ubah Keterangan
                        <SquarePen />
                    </Button> -->
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
        </div>
    </div>

    <div class="shadow-md p-2 rounded-lg flex my-4">
        <!-- <div class="shadow-md p-2 rounded-lg flex flex-row gap-2 w-full my-4"> -->
        <div class="w-full">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold p-2">Riwayat Pencairan Bantuan</h2>
                <div class="flex gap-2">
                    <Button
                        @click="isEditStatusBantuanDialogOpen = true"
                        variant="secondary"
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
                    :actions="0"
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

    <EditStatusBantuanDialog
        v-model:isOpen="isEditStatusBantuanDialogOpen"
        :initial-data="itemPenerimaBantuan"
        @success="
            () => {
                fetchDetailPenerimaBantuan(uuid),
                    (isEditStatusBantuanDialogOpen = false);
            }
        "
    />

    <EditStatusPencairanDialog
        v-model:isOpen="isEditStatusPencairanDialogOpen"
        :initial-data="item"
        @success="
            () => {
                fetchDataPencairan(itemPenerimaBantuan.value.id),
                    (isEditStatusPencairanDialogOpen = false);
            }
        "
    />
</template>
