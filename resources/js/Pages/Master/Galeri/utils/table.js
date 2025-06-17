import { Eye, Edit, Trash } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

export const columnsIndex = [
    { label: "Judul", key: "judul" },
    { label: "Username", key: "username" },
];

export const actionsIndex = [
    {
        label: "Manage",
        icon: Eye,
        handler: (item) => {
            console.log("Manage item:", item);

            if (!item.uuid) {
                alert("UUID tidak ditemukan!");
                return;
            }

            if (!route().has("galeri.show")) {
                alert("Route galeri.show tidak tersedia!");
                return;
            }

            const url = route("galeri.show", { galeri: item.uuid });
            console.log("Navigating to:", url);
            router.visit(url);
        },
    },
    // {
    //     label: "Edit",
    //     icon: Edit,
    //     handler: (item) => {
    //         router.visit(route("galeri.edit", item.uuid));
    //     },
    // },
    // {
    //     label: "Hapus",
    //     icon: Trash,
    //     handler: (item) => {
    //         console.log("Hapus item:", item);
    //     },
    // },
];
