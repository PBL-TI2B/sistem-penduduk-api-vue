import { PenBoxIcon, Trash2 } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

export const columnsIndex2 = [
    { label: "Nama Dusun", key: "nama" },
    { label: "Deskripsi", key: "deskripsi" },
    { label: "Lokasi", key: "lokasi" },
];

export function getActionsDusun({ onEdit, onDelete }) {
    return [
        {
            label: "Edit",
            icon: PenBoxIcon,
            handler: (item) => onEdit(item),
        },
        {
            label: "Hapus",
            icon: Trash2,
            handler: (item) => onDelete(item),
            disabled: (item) => item.rw_count > 0,
        },
    ];
}

export const rowsShow = [
    {
        label: "Nama Dusun",
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
