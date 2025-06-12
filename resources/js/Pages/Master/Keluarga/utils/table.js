import { Eye, PenBoxIcon, Trash2 } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import dayjs from "dayjs";

const columnsIndexKK = [
    {
        label: "No KK",
        key: "no_kk",
        format: (val, row) => row?.nomor_kk || "-",
    },
    {
        label: "NIK",
        key: "penduduk.nik",
        format: (val, row) => row?.anggota_keluarga[0].penduduk?.nik || "-",
    },
    {
        label: "Kepala Keluarga",
        key: "penduduk.nama_lengkap",
        format: (val, row) =>
            row?.anggota_keluarga[0].penduduk?.nama_lengkap || "-",
    },
    {
        label: "Jenis Kelamin",
        key: "jenis_kelamin",
        format: (val, row) =>
            row.anggota_keluarga[0].penduduk?.jenis_kelamin === "L"
                ? "Laki-laki"
                : "Perempuan",
    },
    {
        label: "No. RT",
        key: "no_rt",
        format: (val, row) => row.rt?.nomor_rt || "-",
    },

    {
        label: "Status Perkawinan",
        key: "penduduk.status_perkawinan",
        format: (val, row) =>
            row?.anggota_keluarga[0].penduduk?.status_perkawinan || "-",
        customClass: (val, row) => {
            const status =
                row?.anggota_keluarga?.[0]?.penduduk?.status_perkawinan;

            if (status === "belum kawin") {
                return "text-blue-600 bg-blue-100 px-2 py-1 rounded";
            } else if (status === "kawin") {
                return "text-green-600 bg-green-100 px-2 py-1 rounded";
            } else if (status === "cerai hidup") {
                return "text-yellow-600 bg-yellow-100 px-2 py-1 rounded";
            } else if (status === "cerai mati") {
                return "text-red-600 bg-red-100 px-2 py-1 rounded";
            }
            return "bg-gray-100 text-gray-600 px-2 py-1 rounded";
        },
    },
];

const actionsIndexKK = [
    {
        label: "Kelola",
        icon: Eye,
        handler: (item) => {
            router.visit(route("keluarga.show", item.uuid));
        },
    },
];

const rowsShowKK = [
    {
        label: "No. KK",
        key: "nomor_kk",
        format: (val, row) => row.nomor_kk || "-",
    },
    {
        label: "No. RT",
        key: "rt",
        format: (val, row) => row.rt?.nomor_rt || "-",
    },
    {
        label: "No. RW",
        key: "rw",
        format: (val, row) => row.rt?.nomor_rw || "-",
    },
    {
        label: "Kelurahan",
        key: "kelurahan",
        format: (val, row) => row.kelurahan || "-",
    },
    {
        label: "Kecamatan",
        key: "kecamatan",
        format: (val, row) => row.kecamatan || "-",
    },
    {
        label: "Kabuptaen",
        key: "kabuptaen",
        format: (val, row) => row.kabuptaen || "-",
    },
    {
        label: "Provinsi",
        key: "provinsi",
        format: (val, row) => row.provinsi || "-",
    },
    {
        label: "Kode Pos",
        key: "kode_pos",
        format: (val, row) => row.kode_pos || "-",
    },
];

const columnsKK = [
    {
        label: "Anggota Keluarga",
        key: "anggota_keluarga",
        format: (val, row) => row.anggota_keluarga || "-",
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

export { columnsIndexKK, actionsIndexKK, rowsShowKK, columnsKK };
