import { Eye } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

const columnsIndex = [
    { label: "Nama Bantuan", key: "nama_bantuan" },
    {
        label: "Kategori",
        key: "kategori",
        format: (val, row) => row.kategori || "-",
    },
    { label: "Nominal", key: "nominal",
        format: (value) => {
            if (value == null || value === "") return '-';
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 2 }).format(value);
        },
    },
    { label: "Periode", key: "periode" },
    { label: "Lama Periode", key: "lama_periode" },
    { label: "Instansi", key: "instansi" },
    { label: "Keterangan", key: "keterangan",
        format: (value) => {
            return value?? '-';
        },
    },
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
    { label: "Nama Bantuan", key: "nama_bantuan" },
    {
        label: "Kategori",
        key: "kategori_bantuan",
        format: (val, row) => row.kategori_bantuan?.kategori || "-",
    },
    { label: "Nominal (Rp.)", key: "nominal" },
    { label: "Periode", key: "periode" },
    { label: "Lama Periode", key: "lama_periode" },
    { label: "Instansi", key: "instansi" },
    { label: "Keterangan", key: "keterangan" },
];


export { columnsIndex, actionsIndex, rowsShow };
