import { Eye } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

const columnsIndex = [
    { label: "Nama Desa", key: "nama" },
    { label: "Deskripsi", key: "deskripsi" },
    { label: "Lokasi", key: "lokasi" },
];

const actionsIndex = [
    {
        label: "Manage",
        icon: Eye,
        handler: (item) => {
            router.visit(route("pekerjaan.show", item.uuid));
        },
    },
];

const rowsShow = [
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

export { columnsIndex, actionsIndex, rowsShow };
