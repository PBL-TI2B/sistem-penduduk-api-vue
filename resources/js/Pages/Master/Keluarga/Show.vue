<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { Button } from "@/components/ui/button";
import { usePage } from "@inertiajs/vue3";
import {
    Eye,
    PenSquareIcon,
    PlusSquare,
    SquarePen,
    Trash2,
} from "lucide-vue-next";
import { route } from "ziggy-js";
import { columnsKK, rowsShowKK } from "./utils/table";
import { useKartuKeluarga } from "@/composables/useKartuKeluarga";
import { onMounted, ref } from "vue";

const { uuid } = usePage().props;
const isFormDialogOpen = ref(false);
const dialogMode = ref("create");
const selectedKematian = ref(null);
const isAlertDeleteOpen = ref(false);
const selectedUuid = ref(null);

console.log(uuid);
const { item, fetchDetailData } = useKartuKeluarga(uuid);

const onClickDeleteKematianButton = (uuid) => {
    selectedUuid.value = uuid;
    isAlertDeleteOpen.value = true;
};

const editKematian = (kematian) => {
    isFormDialogOpen.value = true;
    dialogMode.value = "edit";
    selectedKematian.value = kematian;
};

const createKematian = () => {
    isFormDialogOpen.value = true;
    dialogMode.value = "create";
};

const onCancelDeleteKematian = () => {
    isAlertDeleteOpen.value = false;
    selectedUuid.value = null;
};
const onConfirmDeleteKematian = async () => {
    if (selectedUuid.value) {
        await deleteData(selectedUuid.value);
        isAlertDeleteOpen.value = false;
        selectedUuid.value = null;
    }
};

onMounted(fetchDetailData);
console.log(item);
</script>

<template>
    <Head title=" | Detail Keluarga" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Keluarga</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Data Keluarga', href: '/admin/keluarga' },
                    { label: 'Detail Keluarga' },
                ]"
            />
        </div>
        <div class="flex gap-2 items-center">
            <Button asChild>
                <Link :href="route('keluarga.edit', uuid)">
                    <SquarePen /> Kartu Keluarga
                </Link>
            </Button>
            <Button @click=""> <Trash2 /> Kartu Keluarga </Button>
        </div>
    </div>
    <div
        class="shadow-md p-2 rounded-lg flex flex-col lg:flex-row gap-2 justify-between"
    >
        <div class="w-full">
            <h2 class="text-lg font-bold p-2">Kartu Keluarga</h2>
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr>
                        <th
                            v-for="row in rowsShowKK"
                            :key="row.key"
                            class="text-left font-medium p-2"
                        >
                            {{ row.label }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd:bg-card/30">
                        <td
                            v-for="row in rowsShowKK"
                            :key="row.key"
                            class="p-2"
                        >
                            {{
                                row.format
                                    ? row.format(item[row.key], item)
                                    : item[row.key]
                            }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="w-full shadow-md p-2 my-4 rounded-lg">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold p-2">Anggota Keluarga</h2>
            <div class="flex gap-2">
                <Button class="flex items-center gap-1">
                    <PlusSquare />
                    Anggota Keluarga
                </Button>
            </div>
        </div>
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr>
                    <th class="text-left font-medium p-2">Nama</th>
                    <th class="text-left font-medium p-2">NIK</th>
                    <th class="text-left font-medium p-2">Status Keluarga</th>
                    <th class="text-left font-medium p-2">Jenis Kelamin</th>
                    <th class="text-left font-medium p-2">Tanggal Lahir</th>
                    <th class="text-left font-medium p-2">Pendidikan</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(anggota, index) in item.anggota_keluarga"
                    :key="index"
                    class="odd:bg-card/30"
                >
                    <td class="p-2">{{ anggota.nama_lengkap }}</td>
                    <td class="p-2">{{ anggota.nik }}</td>
                    <td class="p-2">{{ anggota.status_keluarga }}</td>
                    <td class="p-2">
                        {{
                            anggota.jenis_kelamin === "L"
                                ? "Laki-Laki"
                                : "Perempuan"
                        }}
                    </td>
                    <td class="p-2">{{ anggota.tanggal_lahir }}</td>
                    <td class="p-2">{{ anggota.pendidikan }}</td>
                    <td class="flex gap-2">
                        <Button variant="secondary">
                            <Eye />
                            Detail</Button
                        >
                        <Button variant="secondary">
                            <Trash2 />
                            Hapus
                        </Button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
