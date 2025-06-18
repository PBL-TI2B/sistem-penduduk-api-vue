export function getFields() {
    return [
        {
            name: "bantuan_id",
            type: "hidden",
            readonly: true,
            disabled: false,
            hidden: true
        },
        {
            name: "kurang_mampu_id",
            type: "hidden",
            readonly: true,
            disabled: false,
            hidden: true
        },
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
