export function getFields(kategoriBantuanOptions = []) {
    return [
        {
            name: "nama_bantuan",
            label: "Nama Bantuan",
            placeholder: "Masukkan Nama Bantuan",
            type: "text",
        },
        {
            name: "kategori_bantuan_id",
            label: "Kategori Bantuan",
            type: "select",
            options: kategoriBantuanOptions, // 👈 dari API
        },
        {
            name: "nominal",
            label: "Nominal (Rp.)",
            placeholder: "Masukkan nominal",
            type: "text",
            optional: true,
        },
        {
            name: "periode",
            label: "Periode Bantuan",
            placeholder: "Contoh: 2021-2025, 2026-2027",
            type: "text",
        },
        {
            name: "lama_periode",
            label: "Lama Periode",
            placeholder: "Contoh: 2 Tahun, 4 Bulan",
            type: "text",
        },
        {
            name: "instansi",
            label: "Instansi",
            placeholder: "Instansi pemberi bantuan",
            type: "text",
        },
        {
            name: "keterangan",
            label: "Keterangan",
            placeholder: "Masukkan keterangan",
            type: "textarea",
            optional: true,

        },
    ];
}
