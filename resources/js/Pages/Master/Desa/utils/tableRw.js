import { PenBoxIcon, Trash2 } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

export const columnsIndex3 = [
    { label: "Nomor RW", key: "nomor_rw" },
    { label: "Dusun", key: "dusun" },
];

export function getActionsRw({ onEdit, onDelete }) {
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
            disabled: (item) => item.rt_count > 0,
        },
    ];
}

export const rowsShow = [
    {
        label: "Nomor RW",
        key: "nomor_rw",
    },
];
