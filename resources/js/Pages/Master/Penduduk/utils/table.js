import { Eye } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import dayjs from "dayjs";

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
    {
        label: "Tanggal Lahir",
        key: "tanggal_lahir",
        format: (val) => dayjs(val).format("DD MMM YYYY"),
    },
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
        customClass: (val) => {
            return val === "hidup"
                ? "text-green-600 bg-green-100"
                : "text-red-600 bg-red-100";
        },
    },
    {
        label: "Status Perkawinan",
        key: "status_perkawinan",
        customClass: (val) => {
            if (val === "belum kawin") {
                return "text-blue-600 bg-blue-100";
            } else if (val === "kawin") {
                return "text-green-600 bg-green-100";
            } else if (val === "cerai hidup") {
                return "text-yellow-600 bg-yellow-100";
            } else if (val === "cerai mati") {
                return "text-red-600 bg-red-100";
            }
        },
    },
];

const actionsIndex = [
    {
        label: "Kelola",
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
        format: (val, row) => row.pekerjaan?.nama_pekerjaan || "-",
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
        label: "Alamat Asal",
        key: "domisili",
        format: (val, row) => row.domisili?.alamat_asal || "-",
    },
    {
        label: "Alamat Saat Ini",
        key: "domisili",
        format: (val, row) => row.domisili?.alamat_saat_ini || "-",
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
