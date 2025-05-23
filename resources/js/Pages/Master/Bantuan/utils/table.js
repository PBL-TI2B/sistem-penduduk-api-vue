import { Eye, Trash2, PackageSearch, SquarePen } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import { useBantuan } from "@/composables/useBantuan";
import { useKategoriBantuan } from "@/composables/useKategoriBantuan";


const columnsIndexBantuan = [
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

const columnsIndexKategori = [
    { label: "Kategori Bantuan", key: "kategori" },
    { label: "Keterangan", key: "keterangan",
        format: (value) => {
            return value? '' || null : '-';
        },
    },
];

export {
    columnsIndexBantuan,
    columnsIndexKategori,
};
