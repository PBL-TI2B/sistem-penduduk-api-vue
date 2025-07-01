export function getFields(rt = []) {
    return [
        {
            name: "nomor_kk",
            label: "No. KK",
            type: "text",
        },
        {
            name: "rt_id",
            label: "No. RT",
            type: "select",
            options: rt,
        },
        {
            name: "kode_pos",
            label: "Kode Pos",
            type: "text",
        },
        {
            name: "kelurahan",
            label: "Kelurahan",
            type: "text",
        },
        {
            name: "kecamatan",
            label: "Kecamatan",
            type: "text",
        },
        {
            name: "kabupaten",
            label: "Kabupaten",
            type: "text",
        },
        {
            name: "provinsi",
            label: "Provinsi",
            type: "text",
        },
    ];
}
