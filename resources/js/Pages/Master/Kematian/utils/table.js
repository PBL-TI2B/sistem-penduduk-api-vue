import { Eye } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

const columnsIndex = [
    { label: "Nama Penduduk", key: "nama_penduduk" },
    { label: "Tanggal Kematian", key: "tanggal_kematian" },
    { label: "Sebab Kematian", key: "sebab_kematian" },
];

const actionsIndex = [
    {
        label: "Manage",
        icon: Eye,
        handler: (item) => {
            router.visit(route("kematian.show", item.uuid));
        },
    },
];

const rowsShow = [
    {
        label: "Penduduk",
        key: "penduduk.nama_lengkap",
    },
    { label: "Tanggal Kematian", key: "tanggal_kematian" },
    { label: "Sebab Kematian", key: "sebab_kematian" },
];

export { columnsIndex, actionsIndex, rowsShow };
