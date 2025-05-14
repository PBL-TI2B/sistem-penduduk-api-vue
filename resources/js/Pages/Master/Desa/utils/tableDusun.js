import { Pencil, Trash } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

const columnsIndex2 = [
    { label: "Nama Dusun", key: "nama" },
    { label: "Deskripsi", key: "deskripsi" },
    { label: "Lokasi", key: "lokasi" },
];

const actionsIndex2 = [
    {
        label: "Edit",
        icon: Pencil,
        handler: (item) => {
            router.visit(route("dusun.edit", item.uuid));
        },
    },
    {
        label: "Hapus",
        icon: Trash,
        handler: (item) => {
            router.visit(route("dusun.edit", item.uuid));
        },
    },
];

const rowsShow = [
    {
        label: "Nama Dusun",
        key: "nama_dusun",
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

export { columnsIndex2, actionsIndex2, rowsShow };
