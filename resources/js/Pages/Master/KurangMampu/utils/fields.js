export function getFields(anggotaKeluarga = []) {
    return [
        // {
        //     name: "kategori_bantuan_id",
        //     label: "Kategori Bantuan",
        //     type: "select",
        //     options: anggotaKeluarga,
        // },
        {
            name: "jumlah_tanggungan",
            label: "Jumlah Tanggungan",
            placeholder: "Masukkan Jumlah Tanggungan",
            type: "number",
        },
        {
            name: "pendapatan_per_hari",
            label: "Pendapatan Per-Hari",
            placeholder: "Masukkan nominal",
            type: "currency",
            // type: "text",
            optional: true,
        },
        {
            name: "keterangan",
            label: "Keterangan",
            placeholder: "Masukkan keterangan",
            type: "textarea",
            optional: true,

        },
        {
            name: "pendapatan_per_bulan",
            label: "Pendapatan Per-Bulan",
            placeholder: "Masukkan nominal",
            type: "currency",
            // type: "text",
            optional: true,
        },

    ];
}
