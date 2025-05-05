import { Eye } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

const columnsIndex = [
    { label: "Nama Lengkap", key: "nama_lengkap" },
    {
        label: "Jenis Kelamin",
        key: "jenis_kelamin",
        format: (value) => {
            return value === "L" ? "Laki-laki" : "Perempuan";
        },
    },
    { label: "Tempat Lahir", key: "tempat_lahir" },
    { label: "Tanggal Lahir", key: "tanggal_lahir" },
    {
        label: "Pendidikan",
        key: "pendidikan",
        format: (val, row) => row.pendidikan?.jenjang || "-",
    },
    {
        label: "Pekerjaan",
        key: "pekerjaan",
        format: (val, row) => row.pekerjaan?.nama_pekerjaan || "-",
    },
    {
        label: "Status",
        key: "status",
    },
    {
        label: "Status Perkawinan",
        key: "status_perkawinan",
    },
];

const actionsIndex = [
    {
        label: "Manage",
        icon: Eye,
        handler: (item) => {
            router.visit(route("penduduk.show", item.uuid));
        },
    },
];

const rowsShow = [
    {
        label: "NIK",
        key: "nik",
    },
    {
        label: "Nama Lengkap",
        key: "nama_lengkap",
    },
    {
        label: "Jenis Kelamin",
        key: "jenis_kelamin",
        format: (value) => {
            return value === "L" ? "Laki-laki" : "Perempuan";
        },
    },
    {
        label: "Tempat Lahir",
        key: "tempat_lahir",
    },
    {
        label: "Tanggal Lahir",
        key: "tanggal_lahir",
    },
    {
        label: "Agama",
        key: "agama",
    },
    {
        label: "Gol. Darah",
        key: "gol_darah",
    },
    {
        label: "Status Perkawinan",
        key: "status_perkawinan",
    },
    {
        label: "Status",
        key: "status",
    },
    {
        label: "Tinggi Badan",
        key: "tinggi_badan",
    },
    {
        label: "Pekerjaan",
        key: "pekerjaan",
        format: (val, row) => row.pendidikan?.nama_pekerjaan || "-",
    },
    {
        label: "Pendidikan",
        key: "pendidikan",
        format: (val, row) => row.pendidikan?.jenjang || "-",
    },
    {
        label: "Ayah",
        key: "ayah",
        format: (val, row) => row.ayah?.nama_lengkap || "-",
    },
    {
        label: "Ibu",
        key: "ibu",
        format: (val, row) => row.ibu?.nama_lengkap || "-",
    },
    {
        label: "Status Tempat Tinggal",
        key: "domisili",
        format: (val, row) => row.domisili?.status_tempat_tinggal || "-",
    },
    {
        label: "RT",
        key: "rt",
        format: (val, row) => row.domisili?.rt || "-",
    },
    {
        label: "RW",
        key: "rw",
        format: (val, row) => row.domisili?.rw || "-",
    },
];

export { columnsIndex, actionsIndex, rowsShow };
