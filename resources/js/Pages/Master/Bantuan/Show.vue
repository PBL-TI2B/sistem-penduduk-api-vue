<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { Button } from "@/components/ui/button";
import { SquarePen, Trash2 } from "lucide-vue-next";
import { rowsIndexBantuan } from "./utils/table";
import { onMounted, ref, computed, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { useBantuan } from "@/composables/useBantuan";
import AlertDialog from "@/components/master/AlertDialog.vue";

const { uuid } = usePage().props;

const selectedUuid = ref(null);
const isFormDialogDomisiliOpen = ref(false);
const isAlertDeleteOpen = ref(false);
const dialogMode = ref("create");

const { item, fetchDetailBantuan, deleteBantuan } = useBantuan();

// const currentBantuanData = computed(() => item.value);

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

onMounted(async () => {
    await fetchDetailBantuan(uuid);
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
                    { label: 'Dashboard', href: '/dashboard' },
                    { label: 'Data Bantuan', href: '/bantuan' },
                    { label: 'Detail Bantuan' },
                ]"
            />
        </div>
    </div>
    <div
        class="shadow-md p-4 rounded-lg flex flex-col lg:flex-row gap-4 justify-between"
    >
        <div class="w-full">
            <h2 class="text-lg font-bold mb-4">
                Detail Data - {{ item.nama_bantuan }}
            </h2>
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
                                    : (item[row.key] ?? "-")
                            }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="flex mt-2 gap-2 items-center justify-end">
                <Button asChild>
                    <Link :href="route('bantuan.edit', uuid)">
                        <SquarePen /> Ubah
                    </Link>
                </Button>
                <Button @click="onClickDeleteButton(uuid)">
                    <Trash2 /> Hapus
                </Button>
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
        v-model:isOpen="isAlertDeleteOpen"
        :title="'Hapus Data Bantuan'"
        :description="'Apakah anda yakin ingin menghapus data bantuan ini?'"
        :onConfirm="onConfirmDelete"
        :onCancel="onCancelDelete"
    />
</template>
