import { Eye, Trash2, PackageSearch, SquarePen } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { formatCurrency, formatDate } from "@/composables/formatData";

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

const columnsIndexAnggotaKeluarga = [
    {
        label: "Nama Lengkap",
        key: "penduduk",
        format: (value) => value?.nama_lengkap ?? '-',
    },
    {
        label: "NIK",
        key: "penduduk",
        format: (value) => value?.nik ?? '-',
    },
    {
        label: "Jenis Kelamin",
        key: "penduduk",
        format: (value) => value?.jenis_kelamin === 'L' ? 'Laki-laki' : (value?.jenis_kelamin === 'P' ? 'Perempuan' : '-'),
    },
    // {
    //     label: "Tempat, Tanggal Lahir",
    //     key: "penduduk",
    //     // format: (value) => value ? `${value.tempat_lahir ?? '-'}, ${formatDate(value.tanggal_lahir)}` : '-',
    //     format: (value) => value ? `${value.tempat_lahir ?? '-'}, ${formatDate(value.tanggal_lahir, false)}` : '-',
    // },
    // {
    //     label: "Agama",
    //     key: "penduduk",
    //     format: (value) => value?.agama ?? '-',
    // },
    {
        label: "Status Perkawinan",
        key: "penduduk",
        format: (value) => value?.status_perkawinan ?? '-',
    },
    {
        label: "Status Keluarga",
        key: "status_keluarga",
        format: (value) => value?.status_keluarga ?? '-',
    },
    {
        label: "Nomor KK",
        key: "kk",
        format: (value) => value?.nomor_kk ?? '-',
    },
];


const actionsIndex = (onClickDeleteButton) => [
    // {
    //     label: "Status",
    //     icon: SquarePen,
    //     handler: (item) => {
    //         // router.visit(route("kurang-mampu.edit", item.uuid));
    //     },
    // },
    {
        label: "Kelola",
        icon: Eye,
        handler: (item) => {
            router.visit(route("kurang-mampu.show", item.uuid));
        },
    },
    // {
    //     label: "Ubah",
    //     icon: SquarePen,
    //     handler: (item) => {
    //         router.visit(route("kurang-mampu.edit", item.uuid));
    //     },
    // },
    {
        label: "Hapus",
        icon: Trash2,
        disabled: (item) => item.penerima_bantuan_count > 0,
        // handler bisa diisi di tempat penggunaan
        handler: (item) => {
            onClickDeleteButton(item.uuid);
        },
    },
];

const rowsShow = [
    { label: "Nama Penduduk", key: "penduduk", format: (value) => value?.nama_lengkap ?? '-' },
    { label: "NIK", key: "penduduk", format: (value) => value?.nik ?? '-' },

    { label: "Jenis Kelamin", key: "penduduk", format: (value) => value?.jenis_kelamin === 'L' ? 'Laki-laki' : (value?.jenis_kelamin === 'P' ? 'Perempuan' : '-') },
    { label: "Tempat, Tanggal Lahir", key: "penduduk", format: (value) => value ? `${value.tempat_lahir ?? '-'}, ${formatDate(value.tanggal_lahir, false)}` : '-' },
    { label: "Agama", key: "penduduk", format: (value) => value?.agama ?? '-' },
    { label: "Pekerjaan", key: "penduduk", format: (value) => value?.pekerjaan ?? '-' },
    { label: "Pendidikan Terakhir", key: "penduduk", format: (value) => value?.pendidikan ?? '-' },
    { label: "Nomor KK", key: "penduduk", format: (value) => value?.no_kk ?? '-' },
    { label: "Status Keluarga", key: "penduduk", format: (value) => value?.status_keluarga ?? '-' },
    { label: "Status Perkawinan", key: "penduduk", format: (value) => value?.status_perkawinan ?? '-' },
    { label: "Nomor RT", key: "penduduk", format: (value) => value?.nomor_rt ?? '-' },
    { label: "Nomor RW", key: "penduduk", format: (value) => value?.nomor_rw ?? '-' },
    { label: "Nama Dusun", key: "penduduk", format: (value) => value?.nama_dusun ?? '-' },

    { label: "Status Validasi", key: "status_validasi" },
    { label: "Pendapatan Per-Hari", key: "pendapatan_per_hari", format: formatCurrency },
    { label: "Pendapatan Per-Bulan", key: "pendapatan_per_bulan", format: formatCurrency },
    { label: "Jumlah Tanggungan", key: "jumlah_tanggungan", format: (value) => value ?? '0' },
    { label: "Keterangan", key: "keterangan", format: (value) => value ?? '-' },
];


export { columnsIndex, columnsIndexAnggotaKeluarga, actionsIndex, rowsShow };
