<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import Button from "@/components/ui/button/Button.vue";
import Badge from "@/components/ui/badge/Badge.vue";

import { rowsShow } from "./utils/table";
import EditStatusDialog from "./components/EditStatusDialog.vue";
import EditDetailDialog from "./components/EditDetailDialog.vue";
import { onMounted, ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useKurangMampu } from "@/composables/useKurangMampu";
// import AlertDialog from "@/components/master/AlertDialog.vue";

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
    item,
    imageUrl,
    fetchDetailData,
    // editStatusValidasi,
    editDetailData,
} = useKurangMampu();

const isEditStatusDialogOpen = ref(false, item);
const isEditDetailDialogOpen = ref(false);

onMounted(() => {
    fetchDetailData(uuid);
});
</script>

<template>
    <Head title=" | Detail Penduduk" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Kurang Mampu</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Data Kurang Mampu', href: '/admin/kurang-mampu' },
                    { label: 'Detail Kurang Mampu' },
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

    <div class="shadow-md p-2 rounded-lg flex gap-2 justify-between my-4">
        <div class="w-full">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold p-2">
                    Detail Kurang Mampu
                    <Badge variant="outline">
                        {{
                            item.status_validasi
                                ? item.status_validasi
                                      .toLowerCase()
                                      .replace(/\b\w/g, (c) => c.toUpperCase())
                                : ""
                        }}
                    </Badge>
                </h2>
                <div class="flex gap-2">
                    <Button
                        @click="isEditStatusDialogOpen = true"
                        variant="secondary"
                    >
                        Ubah Status Validasi
                        <SquarePen />
                    </Button>
                    <Button
                        @click="isEditDetailDialogOpen = true"
                        variant="secondary"
                    >
                        Ubah Detail Data
                        <SquarePen />
                    </Button>
                </div>
            </div>

            <table class="w-full gap-2 table">
                <tr
                    v-for="row in rowsShow.slice(13)"
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
    </div>

    <div
        class="shadow-md p-2 rounded-lg flex flex-col lg:flex-row gap-2 justify-between"
    >
        <div class="w-full">
            <h2 class="text-lg font-bold p-2">
                <!-- Detail Data - {{ item.penduduk.nama_lengkap ?? "-" }} -->
                Detail Data Penduduk
            </h2>
            <table class="w-full gap-2 table">
                <tr
                    v-for="row in rowsShow.slice(0, -5)"
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
        <img
            :src="
                imageUrl
                    ? imageUrl
                    : 'https://placehold.co/300x400?text=No+Photo'
            "
            alt="Foto Penduduk"
            loading="lazy"
            class="rounded-md w-[450px] h-[600px] object-cover"
        />
    </div>

    <EditStatusDialog
        v-model:isOpen="isEditStatusDialogOpen"
        :initial-data="item"
        @success="
            () => {
                fetchDetailData(uuid);
                isEditStatusDialogOpen = false;
            }
        "
    />

    <EditDetailDialog
        v-model:isOpen="isEditDetailDialogOpen"
        :initial-data="item"
        @success="
            () => {
                fetchDetailData(uuid);
                isEditDetailDialogOpen = false;
            }
        "
    />
</template>
