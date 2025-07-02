import { PenBoxIcon, Trash2 } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

export const columnsIndex = [
    { label: "Nama Desa", key: "nama" },
    { label: "Deskripsi", key: "deskripsi" },
    { label: "Lokasi", key: "lokasi" },
];

export function getActionsDesa({ onEdit, onDelete }) {
    return [
        {
            label: "Edit",
            icon: PenBoxIcon,
            handler: (item) => onEdit(item),
            disabled: (item) =>
                item.perangkat_desa_count > 0 || item.dusun_count > 0,
        },
        {
            label: "Hapus",
            icon: Trash2,
            handler: (item) => onDelete(item),
            disabled: (item) =>
                item.perangkat_desa_count > 0 || item.dusun_count > 0,
        },
    ];
}

export const rowsShow = [
    {
        label: "Nama Desa",
        key: "nama",
    },
    {
        label: "Deskripsi",
        key: "deskripsi",
    },
    {
        label: "Lokasi",
        key: "lokasi",
    },
];
