import { Eye } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

const columnsIndex = [
    // { label: "Nama Penduduk", key: "anggota_keluarga_id" },
    {
        label: "Nama Penduduk",
        key: "nama_lengkap",
    },
    {
        label: "Pendapatan Per-Hari",
        key: "pendapatan_per_hari",
        format: (value) => {
            if (value == null || value === '') return '-';
            return Number(value).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 2 });
        },
    },
    {
        label: "Pendapatan Per-Bulan",
        key: "pendapatan_per_bulan",
        format: (value) => {
            if (value == null || value === '') return '-';
            return Number(value).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 2 });
        },
    },
    {
        label: "Tanggungan",
        key: "jumlah_tanggungan",
        format: (value) => {
            return value?? '0';
        },
    },
    { label: "Pekerjaan", key: "pekerjaan" },
    { label: "Status Valiasi", key: "status_validasi" },
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
