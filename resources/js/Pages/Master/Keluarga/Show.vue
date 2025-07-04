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

import { ref, onMounted } from "vue";
import { useAnggotaKeluarga } from "@/composables/useAnggotaKeluarga";
import FormDialogAnggotaKeluarga from "./components/FormDialogAnggotaKeluarga.vue";
import { toast } from "vue-sonner";
import AlertDialog from "@/components/master/AlertDialog.vue";

const isFormAnggotaOpen = ref(false);

const { uuid } = usePage().props;
const isAlertDeleteOpen = ref(false);
const selectedUuid = ref(null);
const { deleteAnggota } = useAnggotaKeluarga();
const statusKeluargaOptions = ref([]);
const kkData = ref({});
const deleteType = ref(""); // "anggota" atau "kk"

console.log(uuid);
const { item, fetchDetailData, deleteData } = useKartuKeluarga(uuid);

const confirmDeleteAnggota = (uuid) => {
    deleteType.value = "anggota";
    selectedUuid.value = uuid;
    isAlertDeleteOpen.value = true;
};

const confirmDeleteKK = () => {
    deleteType.value = "kk";
    selectedUuid.value = null;
    isAlertDeleteOpen.value = true;
};

const onCancelDelete = () => {
    isAlertDeleteOpen.value = false;
    selectedUuid.value = null;
    deleteType.value = "";
};

const onConfirmDelete = async () => {
    try {
        if (deleteType.value === "anggota" && selectedUuid.value) {
            await deleteAnggota(selectedUuid.value);
            toast.success("Anggota keluarga berhasil dihapus");
            await fetchDetailData();
        } else if (deleteType.value === "kk") {
            await deleteData();
            toast.success("Kartu Keluarga berhasil dihapus");
            window.location.href = "/admin/keluarga";
        }
    } catch (e) {
        toast.error("Gagal menghapus data");
    } finally {
        isAlertDeleteOpen.value = false;
        selectedUuid.value = null;
        deleteType.value = "";
    }
};

onMounted(async () => {
    await fetchDetailData();
    // Fetch status keluarga dari API
    try {
        const resStatus = await apiGet("/status-keluarga");
        statusKeluargaOptions.value = resStatus.data.data.map((item) => ({
            value: item.id.toString(),
            label: item.status_keluarga,
        }));
    } catch (error) {
        // opsional: handle error
    }
});

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
            <Button @click="confirmDeleteKK">
                <Trash2 /> Kartu Keluarga
            </Button>
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
                <Button
                    class="flex items-center gap-1"
                    @click="isFormAnggotaOpen = true"
                >
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
                        <!-- <Button
                            variant="secondary"
                            @click="
                                router.visit(
                                    route(
                                        'penduduk.show',
                                        anggota.penduduk.uuid
                                    )
                                )
                            "
                        >
                            <Eye />
                            Penduduk
                        </Button> -->

                        <Button
                            variant="secondary"
                            @click="confirmDeleteAnggota(anggota.uuid)"
                        >
                            <Trash2 />
                            Hapus
                        </Button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <FormDialogAnggotaKeluarga
        :isOpen="isFormAnggotaOpen"
        :kkId="item.id"
        @update:isOpen="isFormAnggotaOpen = $event"
        @success="fetchDetailData"
    />

    <AlertDialog
        v-model:isOpen="isAlertDeleteOpen"
        :title="
            deleteType === 'kk'
                ? 'Hapus Kartu Keluarga'
                : 'Hapus Anggota Keluarga'
        "
        :description="
            deleteType === 'kk'
                ? 'Apakah anda yakin ingin menghapus kartu keluarga ini? Semua anggota akan ikut terhapus.'
                : 'Apakah anda yakin ingin menghapus anggota keluarga ini?'
        "
        :onConfirm="onConfirmDelete"
        :onCancel="onCancelDelete"
    />
</template>
