import { Eye } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

const columnsIndex = [
    { label: "Tanggal Kematian", key: "tanggal_kematian" },
    { label: "Sebab Kematian", key: "sebab_kematian" },
    { label: "Nama Penduduk", key: "nama_penduduk" },
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
    { label: "Tanggal Kematian", key: "tanggal_kematian" },
    { label: "Sebab Kematian", key: "sebab_kematian" },
    {
        label: "Penduduk",
        key: "penduduk.nama_lengkap",
    },
];

export { columnsIndex, actionsIndex, rowsShow };
