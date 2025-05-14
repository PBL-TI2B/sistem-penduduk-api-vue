export function getFields(
    penduduk = [],
    jabatan = [],
    periode_jabatan = [],
    desa = [],
    dusun = [],
    rt = [],
    rw = []
) {
    return [
        {
            name: "status_keaktifan",
            label: "Status Keaktifan",
            type: "select",
            options: [
                { value: "aktif", label: "Aktif" },
                { value: "nonaktif", label: "Non Aktif" },
            ],
        },
        {
            name: "penduduk_id",
            label: "Penduduk",
            type: "select",
            options: penduduk,
        },
        {
            name: "jabatan_id",
            label: "Jabatan",
            type: "select",
            options: jabatan,
        },
        {
            name: "periode_jabatan_id",
            label: "Periode Jabatan",
            type: "select",
            options: periode_jabatan,
        },
        {
            name: "desa_id",
            label: "Desa",
            type: "select",
            options: desa,
        },
        {
            name: "dusun_id",
            label: "Dusun",
            type: "select",
            options: dusun,
        },
        {
            name: "rt_id",
            label: "RT",
            type: "select",
            options: rt,
        },
        {
            name: "rw_id",
            label: "RW",
            type: "select",
            options: rw,
        },
    ];
}
