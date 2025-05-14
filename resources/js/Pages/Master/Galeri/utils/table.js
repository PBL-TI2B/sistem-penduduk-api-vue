import { Eye, Edit, Trash } from "lucide-vue-next";

export const columnsIndex = [
    { label: "Judul", key: "judul" },
    // { label: "Slug", key: "slug" },
    { label: "Tanggal Post", key: "tanggal_post" },
    { label: "URL Media", key: "url_media" },
    {
        label: "User",
        key: "user",
        format: (val, row) => row.user?.name || "-",
    },
];

export const actionsIndex = [
    {
        label: "Lihat",
        icon: Eye,
        handler: (item) => {
            console.log("Lihat item:", item);
        },
    },
    {
        label: "Edit",
        icon: Edit,
        handler: (item) => {
            console.log("Edit item:", item);
        },
    },
    {
        label: "Hapus",
        icon: Trash,
        handler: (item) => {
            console.log("Hapus item:", item);
        },
    },
];