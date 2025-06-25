import { Eye, Edit, Trash } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import { route } from "ziggy-js";

export const columnsIndex = [
    {
        label: "Judul",
        key: "judul",
        format: (val, row) => row.judul.substring(0, 30) + "...",
    },
    { label: "Tanggal Posting", key: "tanggal_post" },
    { label: "Terakhir Diubah", key: "terakhir_diubah" },
    { label: "Status", key: "status" },
    {
        label: "Penulis",
        key: "username",
        format: (val, row) => row.user.username,
    },
    { label: "Dilihat", key: "jumlah_dilihat" },
];

export const actionsIndex = [
    {
        label: "Manage",
        icon: Eye,
        handler: (item) => {
            if (!item.slug) {
                alert("Slug tidak ditemukan!");
                return;
            }
            if (!route().has("berita.show")) {
                alert("Route berita.show tidak tersedia!");
                return;
            }

            const url = route("berita.show", { berita: item.slug });
            router.visit(url);
        },
    },
    // {
    //     label: "Edit",
    //     icon: Edit,
    //     handler: (item) => {
    //         if (!item.uuid) {
    //             alert("UUID tidak ditemukan!");
    //             return;
    //         }
    //         if (!route().has('berita.edit')) {
    //             alert("Route berita.edit tidak tersedia!");
    //             return;
    //         }
    //         const url = route("berita.edit", { berita_admin: item.uuid });
    //         router.visit(url);
    //     }
    // },
    // {
    //     label: "Hapus",
    //     icon: Trash,
    //     handler: (item) => {
    //         // Implementasi hapus bisa menggunakan dialog konfirmasi
    //         // atau emit event ke parent
    //         console.log("Hapus item:", item);
    //     },
    // },
];
