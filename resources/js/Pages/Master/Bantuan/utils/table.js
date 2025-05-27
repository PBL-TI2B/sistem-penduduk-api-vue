import { Eye, Trash2, PackageSearch, SquarePen } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { formatCurrency, formatDate } from "@/composables/formatData";

// Table Index
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

// Table Index
const columnsIndexKategori = [
    { label: "Kategori Bantuan", key: "kategori" },
    { label: "Keterangan", key: "keterangan",
        format: (value) => {
            return value? '' || null : '-';
        },
    },
];

// Row Show
const rowsIndexBantuan = [
    { label: "Nama Bantuan", key: "nama_bantuan" },
    {
        label: "Kategori Bantuan",
        key: "kategori",
        // format: (val, row) => val?.kategori || "-",
    },
    { label: "Nominal", key: "nominal",
        format: formatCurrency
    },
    { label: "Periode", key: "periode" },
    { label: "Lama Periode", key: "lama_periode" },
    { label: "Instansi", key: "instansi" },
    { label: "Keterangan", key: "keterangan",
        format: (value) => {
            return value ?? '-';
        },
    },
    { label: "Dibuat Pada", key: "created_at",
        format: formatDate
    },
    { label: "Diperbarui Pada", key: "updated_at",
        format: formatDate
    },
];

const actionsIndexBantuan = (
    onClickDeleteBantuanButton
) => [
    {
        label: "Kelola",
        icon: Eye,
        handler: (item) => {
            router.visit(route("bantuan.show", item.uuid));
        },
    },
    {
        label: "Ubah",
        icon: SquarePen,
        handler: (item) => {
            router.visit(route("bantuan.edit", item.uuid));
        },
    },
    {
        label: "Hapus",
        icon: Trash2,
        handler: (item) => {
            onClickDeleteBantuanButton(item.uuid);
        },
        disabled: (item) => item.penerima_bantuan_count > 0,
    },
];

const actionsIndexKategori = ({
    selectedKategori,
    applyFilter, editKategoriBantuan,
    onClickDeleteKategoriButton
}) => [
    {
        label: "Cari",
        icon: PackageSearch,
        handler: (item) => {
            selectedKategori.value = item.id;
            applyFilter();
        },
        disabled: (item) => item.bantuan_count == 0,
    },
    {
        label: "Ubah",
        icon: Eye,
        handler: (item) => {
            editKategoriBantuan(item);
        },
    },
    {
        label: "Hapus",
        icon: Trash2,
        handler: (item) => {
            onClickDeleteKategoriButton(item.uuid);
        },
        disabled: (item) => item.bantuan_count > 0,
    },
];


export {
    columnsIndexBantuan,
    columnsIndexKategori,
    rowsIndexBantuan,
    actionsIndexBantuan,
    actionsIndexKategori,
};
