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
            placeholder: "Contoh: Klaten",
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
            label: "Tinggi Badan (cm)",
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

export function getFieldDomisili(rt_id = []) {
    return [
        {
            name: "status_tempat_tinggal",
            label: "Status Tempat Tinggal",
            type: "select",
            options: ["tetap", "sementara"],
        },
        {
            name: "rt_id",
            label: "RT",
            type: "select",
            options: rt_id,
        },
        {
            name: "alamat_asal",
            label: "Alamat Asal",
            type: "text",
            placeholder: "Masukkan alamat asal",
        },
        {
            name: "alamat_saat_ini",
            label: "Alamat saat ini",
            type: "text",
            placeholder: "Masukkan alamat saat ini",
        },
    ];
}
