import { Eye } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import { route } from "ziggy-js";

const columnsIndex = [
    { label: "Tanggal Kematian", key: "tanggal_kematian" },
    { label: "Sebab Kematian", key: "sebab_kematian" },
    { label: "Nama Penduduk", key: "nama_penduduk" },
];

const actionsIndex = (onClickDeleteBantuanButton) => [
    {
        label: "Ubah",
        icon: SquarePen,
        handler: (item) => {},
    },
    {
        label: "Hapus",
        icon: Trash2,
        handler: (item) => {
            onClickDeleteBantuanButton(item.uuid);
        },
        disabled: (item) => item.penerima_bantuan_count > 0,
    },
];

const rowsShow = [
    { label: "Tanggal Kematian", key: "tanggal_kematian" },
    { label: "Sebab Kematian", key: "sebab_kematian" },
    {
        label: "Penduduk",
        key: "penduduk.nama_lengkap",
    },
];

export { columnsIndex, actionsIndex, rowsShow };
