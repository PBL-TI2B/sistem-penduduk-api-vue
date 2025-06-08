export function getFields(rt = [], no_kk = []) {
    return [
        {
            name: "no_kk",
            label: "No. KK",
            type: "select",
            options: no_kk,
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
            type: "input",
        },
        {
            name: "kecamatan",
            label: "Kecamatan",
            type: "input",
        },
        {
            name: "kabupaten",
            label: "Kabupaten",
            type: "input",
        },
        {
            name: "provinsi",
            label: "Provinsi",
        },
    ];
}
