import { Eye, PencilIcon, Trash2Icon } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { formatCurrency, formatDate } from "@/composables/formatData";

const columnsIndex = [
    {
        label: "Nama Penduduk",
        key: "kurang_mampu",
        format: (val, row) => val?.penduduk.nama_lengkap || "-",
    },
    {
        label: "Nama Bantuan",
        key: "bantuan",
        format: (val, row) => val?.nama_bantuan || "-",
    },
    // {
    //     label: "Pendapatan Per-Hari (Rp.)",
    //     key: "kurang_mampu",
    //     format: (val) =>
    //         val != null
    //             ? Number(val.pendapatan_per_hari).toLocaleString('id-ID', {
    //                 style: 'currency',
    //                 currency: 'IDR',
    //                 minimumFractionDigits: 2,
    //             })
    //             : "-",
    // },
    // {
    //     label: "Pendapatan Per-Bulan (Rp.)",
    //     key: "kurang_mampu",
    //     format: (val) =>
    //         val != null
    //             ? Number(val.pendapatan_per_bulan).toLocaleString('id-ID', {
    //                 style: 'currency',
    //                 currency: 'IDR',
    //                 minimumFractionDigits: 2,
    //             })
    //             : "-",
    // },

    {
        label: "Tanggungan",
        key: "kurang_mampu",
        format: (val) => val?.jumlah_tanggungan ?? "-",
    },
    {
        label: "Tanggal Penerimaan",
        key: "tanggal_penerimaan",
        format: (val) => {
            if (!val) return "-";
            const date = new Date(val);
            const hari = date.toLocaleDateString('id-ID', { weekday: 'long' });
            const tanggal = date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
            });
            return `${hari}, ${tanggal}`;
        },
    },
    {
        label: "Status Bantuan",
        key: "status",
        format: (val) => val ?? "-",
    },
];

const columnsIndexBantuan = [
    { label: "Nama Bantuan", key: "nama_bantuan" },
    { label: "Kategori",key: "kategori", },
    { label: "Nominal", key: "nominal",
        format: formatCurrency
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

const columnsIndexKurangMampu = [
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


const actionsIndex =  (onClickDeleteButton) => [
    {
        label: "Kelola",
        icon: Eye,
        class: "bg-blue-500 hover:bg-blue-600 text-white", // warna biru untuk lihat
        handler: (item) => {
            router.visit(route("penerima-bantuan.show", item.uuid));
        },
    },
    // {
    //     label: "Ubah",
    //     icon: PencilIcon,
    //     class: "bg-yellow-500 hover:bg-yellow-600 text-white", // warna kuning untuk edit
    //     handler: (item) => {
    //         router.visit(route("penerima-bantuan.edit", item.uuid));
    //     },
    // },
    {
        label: "Hapus",
        icon: Trash2Icon,
        class: "bg-red-500 hover:bg-red-600 text-white", // warna merah untuk hapus
        disabled: (item) => item.riwayat_bantuan_count > 0,
        // handler: (item) => {
        //     if (confirm("Yakin ingin menghapus data ini?")) {
        //         router.delete(route("penerima-bantuan.destroy", item.uuid));
        //     }
        // },
        // handler bisa diisi di tempat penggunaan
        handler: (item) => {
            onClickDeleteButton(item.uuid);
        },
    },
];

const rowsShow = [
//     { label: "Nama Bantuan", key: "nama_bantuan" },
{
        label: "Nama Lengkap",
        key: "kurang_mampu",
        format: (val, row) => val?.penduduk.nama_lengkap || "-",
    },
    {
        label: "NIK",
        key: "kurang_mampu",
        format: (val, row) => val?.penduduk.nik || "-",
    },
    {
        label: "Bantuan",
        key: "bantuan",
        format: (val, row) => val?.nama_bantuan || "-",
    },
    {
        label: "Tanggungan",
        key: "kurang_mampu",
        format: (val) => val?.jumlah_tanggungan ?? "-",
    },
    {
        label: "Tanggal Penerimaan",
        key: "tanggal_penerimaan",
        // format: (val) => formatDate(val, false),
        format: (val) => {
            if (!val) return "-";
            const date = new Date(val);
            const hari = date.toLocaleDateString('id-ID', { weekday: 'long' });
            const tanggal = date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
            });
            return `${hari}, ${tanggal}`;
        },
    },
    {
        label: "Status Bantuan",
        key: "status",
        format: (val) => val ?? "-",
    },
];


export { columnsIndex, columnsIndexBantuan, columnsIndexKurangMampu, actionsIndex, rowsShow };
