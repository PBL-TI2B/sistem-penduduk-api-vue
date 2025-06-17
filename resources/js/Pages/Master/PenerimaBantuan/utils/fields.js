export function getFields() {
    return [

        {
            name: "nama_penduduk",
            label: "Nama Penduduk",
            type: "text",
            readonly: true,
            disabled: false
        },
        {
            name: "tanggal_penerimaan",
            label: "Tanggal Penerimaan",
            type: "datepicker",
        },
        {
            name: "nama_bantuan",
            label: "Jenis Bantuan",
            type: "text",
            readonly: true,
            disabled: false
        },
        {
            name: "keterangan",
            label: "Keterangan",
            type: "textarea",
        },
    ];
}
