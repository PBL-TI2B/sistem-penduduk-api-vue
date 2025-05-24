import { Eye, PencilIcon, Trash2Icon } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

const columnsIndex = [
    {
        label: "Nama Penduduk",
        key: "kurang_mampu",
        format: (val, row) => val?.nama_lengkap || "-",
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
        format: (val) => val.jumlah_tanggungan ?? "-",
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


const actionsIndex = [
    {
        label: "Kelola",
        icon: Eye,
        class: "bg-blue-500 hover:bg-blue-600 text-white", // warna biru untuk lihat
        handler: (item) => {
            router.visit(route("penerima-bantuan.show", item.uuid));
        },
    },
    {
        label: "Ubah",
        icon: PencilIcon,
        class: "bg-yellow-500 hover:bg-yellow-600 text-white", // warna kuning untuk edit
        handler: (item) => {
            router.visit(route("penerima-bantuan.edit", item.uuid));
        },
    },
    {
        label: "Hapus",
        icon: Trash2Icon,
                class: "bg-red-500 hover:bg-red-600 text-white", // warna merah untuk hapus
        handler: (item) => {
            if (confirm("Yakin ingin menghapus data ini?")) {
                router.delete(route("penerima-bantuan.destroy", item.uuid));
            }
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
