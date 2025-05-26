
import { router } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import {
//     PackagePlus,
//     SearchIcon,
    Eye,
    Trash2,
    // PackageSearch,
//     X,
//     FunnelX,
    SquarePen,
} from "lucide-vue-next";

const formatCurrency = (value) => {
    if (value == null || value === '') return '-';
    return Number(value).toLocaleString('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 2
    });
};

const columnsIndex = [
    {
        label: "Nama Penduduk",
        key: "penduduk",
        format: (value) => value?.nama_lengkap ?? '-',
    },
    {
        label: "NIK",
        key: "penduduk",
        format: (value) => value?.nik ?? '-',
    },
    {
        label: "Pendapatan Per-Hari",
        key: "pendapatan_per_hari",
        format: formatCurrency,
    },
    {
        label: "Pendapatan Per-Bulan",
        key: "pendapatan_per_bulan",
        format: formatCurrency,
    },
    {
        label: "Tanggungan",
        key: "jumlah_tanggungan",
        format: (value) => value ?? '0',
    },
    {
        label: "Pekerjaan",
        key: "penduduk",
        format: (value) => value?.pekerjaan ?? '-',
    },
    {
        label: "Pendidikan Terakhir",
        key: "penduduk",
        format: (value) => value?.pendidikan ?? '-',
    },
    {
        label: "Status Validasi",
        key: "status_validasi"
    },
];

// export default columnsIndex;

const actionsIndex = (router, route) => [
    {
        label: "Kelola",
        icon: Eye,
        handler: (item) => {
            router.visit(route("kurang-mampu.show", item.uuid));
        },
    },
    {
        label: "Ubah",
        icon: SquarePen,
        handler: (item) => {
            router.visit(route("kurang-mampu.edit", item.uuid));
        },
    },
    {
        label: "Hapus",
        icon: Trash2,
        disabled: (item) => item.penerima_bantuan_count > 0,
        // handler bisa diisi di tempat penggunaan
    },
];

const rowsShow = [
//     { label: "Nama Bantuan", key: "nama_bantuan" },
//     {
//         label: "Kategori",
//         key: "anggota_keluarga",
//         format: (val, row) => row.anggota_keluarga?.kategori || "-",
//     },
//     { label: "Nominal (Rp.)", key: "nominal" },
//     { label: "Periode", key: "periode" },
//     { label: "Lama Periode", key: "lama_periode" },
//     { label: "Instansi", key: "instansi" },
//     { label: "Keterangan", key: "keterangan" },
];

export { columnsIndex, actionsIndex, rowsShow };
