// resources/js/Pages/Master/Kematian/utils/fields.js

export function getFields() {
    return [
        {
            name: "tanggal_kematian",
            label: "Tanggal Kematian",
            placeholder: "Pilih tanggal kematian",
            type: "date",
        },
        {
            name: "sebab_kematian",
            label: "Sebab Kematian",
            placeholder: "Masukkan sebab kematian",
            type: "text",
        },
        {
            name: "penduduk_id",
            label: "Penduduk",
            placeholder: "Pilih penduduk",
            type: "select",
            api: "/penduduk",
            optionLabel: "nama_lengkap",
            optionValue: "id",
        },
    ];
}
