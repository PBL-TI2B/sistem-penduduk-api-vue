import { Eye } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

const columnsIndex2 = [
    { label: "Nama Desa", key: "nama" },
    { label: "Deskripsi", key: "deskripsi" },
    { label: "Lokasi", key: "lokasi" },
];

const actionsIndex2 = [
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
        label: "Nama Pekerjaan",
        key: "nama_pekerjaan",
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
