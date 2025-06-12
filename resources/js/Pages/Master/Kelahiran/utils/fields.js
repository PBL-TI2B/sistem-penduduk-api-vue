export function getFields(pekerjaanOptions = [], pendidikanOptions = []) {
    return [
        {
            name: "nik",
            label: "NIK",
            placeholder: "Masukkan NIK",
            type: "text",
        },
        {
            name: "nama_lengkap",
            label: "Nama Lengkap",
            placeholder: "Masukkan nama lengkap",
            type: "text",
        },
        {
            name: "jenis_kelamin",
            label: "Jenis Kelamin",
            type: "select",
            options: ["L", "P"],
        },
        {
            name: "tempat_lahir",
            label: "Tempat Lahir",
            placeholder: "Masukkan tempat lahit (cth: Klaten)",
            type: "text",
        },
        { name: "tanggal_lahir", label: "Tanggal Lahir", type: "datepicker" },
        {
            name: "agama",
            label: "Agama",
            type: "select",
            options: [
                "Islam",
                "Kristen",
                "Katolik",
                "Hindu",
                "Budha",
                "Konghucu",
            ],
        },
        {
            name: "gol_darah",
            label: "Golongan Darah",
            type: "select",
            options: ["A", "B", "AB", "O"],
        },
        {
            name: "status_perkawinan",
            label: "Status Perkawinan",
            type: "select",
            options: ["belum kawin", "kawin", "cerai hidup", "cerai mati"],
        },
        {
            name: "tinggi_badan",
            placeholder: "Masukkan tinggi badan (cm)",
            type: "text",
            optional: true,
        },
        {
            name: "status",
            label: "Status",
            type: "select",
            options: ["hidup", "mati"],
        },
        {
            name: "pekerjaan_id",
            label: "Pekerjaan",
            type: "select",
            options: pekerjaanOptions, // 👈 dari API
        },
        {
            name: "pendidikan_id",
            label: "Pendidikan",
            type: "select",
            options: pendidikanOptions, // 👈 dari API
        },
    ];
}

export const fieldsKelahiran = [
    {
        name: "anak_ke",
        label: "Anak ke-",
        placeholder: "Masukkan anak ke berapa (cth: 1)",
        type: "number",
    },
    {
        name: "berat",
        label: "Berat (gram)",
        placeholder: "Masukkan berat anak (cth: 3000)",
        type: "number",
    },
    {
        name: "panjang",
        label: "Panjang (cm)",
        placeholder: "Masukkan panjang anak (cth: 50)",
        type: "number",
    },
    {
        name: "waktu_kelahiran",
        label: "Waktu Kelahiran",
        placeholder: "Masukkan waktu kelahiran",
        type: "datepicker",
    },
    {
        name: "lokasi",
        label: "Lokasi Kelahiran",
        placeholder: "Masukkan lokasi kelahiran (cth: Rumah sakit)",
        type: "text",
    },
    {
        name: "keterangan",
        label: "Keterangan",
        placeholder: "Masukkan keterangan",
        type: "text",
    },
];
