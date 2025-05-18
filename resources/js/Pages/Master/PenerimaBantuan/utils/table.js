import { Eye } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

const columnsIndex = [
    {
        label: "Nama Penduduk",
        key: "kurang_mampu_id",
        format: (val, row) => row.kurang_mampu_id?.nama_penerima || "-",
    },
    {
        label: "Nama Bantuan",
        key: "bantuan_id",
        format: (val, row) => row.bantuan_id?.nama_bantuan || "-",
    },
    {
        label: "Pendapatan Per-Hari (Rp.)",
        key: "kurang_mampu_id",
        format: (val, row) => {
            const value = row.kurang_mampu_id?.pendapatan_per_hari;
            return value != null
                ? Number(value).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 2 })
                : "-";
        },
    },
    {
        label: "Pendapatan Per-Bulan (Rp.)",
        key: "kurang_mampu_id",
        format: (val, row) => {
            const value = row.kurang_mampu_id?.pendapatan_per_hari;
            return value != null
                ? Number(value).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 2 })
                : "-";
        },
    },
    {
        label: "Tanggungan",
        key: "kurang_mampu_id",
        format: (val, row) => row.kurang_mampu_id?.jumlah_tanggungan || "-",
    },
    { label: "Status Valiasi", key: "status" },
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
