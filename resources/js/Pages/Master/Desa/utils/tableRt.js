import { PenBoxIcon, Trash2 } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

export const columnsIndex4 = [
    { label: "Nomor Rt", key: "nomor_rt" },
    { label: "Nomor Rw", key: "rw" },
];

export function getActionsRt({ onEdit, onDelete }) {
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
            disabled: (item) => item.perangkat_desa_count > 0,
        },
    ];
}

export const rowsShow = [
    {
        label: "Nomor RT",
        key: "nomor_rt",
    },
];
