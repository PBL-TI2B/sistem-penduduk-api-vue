import { PenBoxIcon, Trash2 } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

export const columnsIndex = [
    { label: "Nama Pekerjaan", key: "nama_pekerjaan" },
];

export function getActionsPekerjaan({ onEdit, onDelete }) {
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
            disabled: (item) => item.penduduk_count > 0,
        },
    ];
}

export const rowsShow = [{ label: "Nama Pekerjaan", key: "nama_pekerjaan" }];
