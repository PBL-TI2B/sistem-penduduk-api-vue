import { Eye, PenBoxIcon, Trash2 } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import dayjs from "dayjs";

const columnsIndexKelahiran = [
    {
        label: "Nama Lengkap",
        key: "penduduk.nama_lengkap",
        format: (val, row) => row?.penduduk.nama_lengkap || "-",
    },
    {
        label: "Anak Ke-",
        key: "anak_ke",
        format: (val, row) => row?.anak_ke || "-",
    },
    {
        label: "Berat",
        key: "berat",
        format: (val, row) => row?.berat || "-",
    },
    {
        label: "Panjang",
        key: "panjang",
        format: (val, row) => row?.panjang || "-",
    },
    {
        label: "Waktu Kelahiran",
        key: "waktu_kelahiran",
        format: (val, row) => row?.waktu_kelahiran || "-",
    },
    {
        label: "Lokasi",
        key: "lokasi",
        format: (val, row) => row?.lokasi || "-",
    },
    {
        label: "Ket",
        key: "keterangan",
        format: (val, row) => row?.keterangan || "-",
    },
];

const actionsIndexKelahiran = [
    {
        label: "Manage",
        icon: Eye,
        handler: (item) => {
            router.visit(route("perangkat-desa.show", item.uuid));
        },
    },
];

const rowsShowKelahiran = [
    {
        label: "Nama Lengkap",
        key: "nama_lengkap",
        format: (val, row) => row.penduduk?.nama_lengkap || "-",
    },
    {
        label: "Jabatan",
        key: "jabatan",
        format: (val, row) => row.jabatan?.jabatan || "-",
    },
    {
        label: "Periode Jabatan",
        key: "periode_jabatan",
        format: (val, row) =>
            row.periode_jabatan
                ? `${dayjs(row.periode_jabatan.awal_menjabat).format(
                      "YYYY"
                  )} - ${dayjs(row.periode_jabatan.akhir_menjabat).format(
                      "YYYY"
                  )}`
                : "-",
    },
    {
        label: "Status Keaktifan",
        key: "status_keaktifan",
        format: (val, row) =>
            row.status_keaktifan === "aktif" ? "Aktif" : "Nonaktif" || "-",
    },
    {
        label: "Desa",
        key: "desa",
        format: (val, row) => row.desa?.nama || "-",
    },
    {
        label: "Dusun",
        key: "dusun",
        format: (val, row) => row.dusun?.nama || "-",
    },
    {
        label: "RW",
        key: "rw",
        format: (val, row) => row.rw?.nomor_rw || "-",
    },
    {
        label: "RT",
        key: "rt",
        format: (val, row) => row.rt?.nomor_rt || "-",
    },
];

const columnsKelahiran = [
    {
        label: "Jabatan",
        key: "jabatan",
        format: (val, row) => row.jabatan || "-",
    },
    {
        label: "Keterangan",
        key: "keterangan",
        format: (val, row) => row.keterangan || "-",
    },
];

// const actionsJabatan = [
//     {
//         label: "",
//         icon: PenBoxIcon,
//         handler: (item) => {},
//     },
//     {
//         label: "",
//         icon: Trash2,
//         handler: (item) => {},
//     },
// ];

export {
    columnsIndexKelahiran,
    actionsIndexKelahiran,
    rowsShowKelahiran,
    columnsKelahiran,
};
