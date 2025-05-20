import { Pencil, Trash } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

export const columnsIndex = [
    { label: "Nama Pekerjaan", key: "nama_pekerjaan" },
];

export function getActionsPekerjaan({ onEdit, onDelete }) {
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

export const rowsShow = [{ label: "Nama Pekerjaan", key: "nama_pekerjaan" }];
