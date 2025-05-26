import { Pencil, Trash } from "lucide-vue-next";
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
            icon: Pencil,
            handler: (item) => onEdit(item),
        },
        {
            label: "Hapus",
            icon: Trash,
            handler: (item) => onDelete(item),
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
