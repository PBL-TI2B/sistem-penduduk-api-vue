import { Eye, PenBoxIcon, Trash2 } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import dayjs from "dayjs";

const columnsIndexUser = [
    {
        label: "Username",
        key: "username",
        format: (val, row) => row?.username || "-",
    },
    {
        label: "Status",
        key: "status",
        format: (val, row) => row?.status || "-",
    },
    {
        label: "Perangkat Desa",
        key: "perangkat_desa.nama_lengkap",
        format: (val, row) => row?.perangkat_desa?.nama_lengkap || "-",
    },
];

const actionsIndexUser = [
    {
        label: "Manage",
        icon: Eye,
        handler: (item) => {
            router.visit(route("perangkat-desa.show", item.uuid));
        },
    },
];

const rowsShowUser = [
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

const columnsUser = [
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

export { columnsIndexUser, actionsIndexUser, rowsShowUser, columnsUser };
