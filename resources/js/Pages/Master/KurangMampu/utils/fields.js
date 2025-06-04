import { items } from "@/components/master/sidebar/sidebarItems";

export function getFields() {
    return [

        {
            name: "nama_penduduk",
            label: "Nama Penduduk",
            type: "text",
            // value: anggotaKeluarga.penduduk.nama_lengkap ?? '-',
            // label: anggotaKeluarga.uuid,
            readonly: true,
            disabled: false
        },
        // {
        //     name: "anggota_keluarga_id",
        //     label: "Anggota Keluarga",
        //     type: "text",
        //     // value: anggotaKeluarga.penduduk.nama_lengkap,
        //     // placeholder: anggotaKeluarga.uuid ?? '-',
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
        {
            name: "anggota_keluarga_id",
            type: "hidden",
            // value: anggotaKeluarga.id,
            // hidden: true,
            // disabled: true
        },
    ];
}
