import { Eye, Edit, Trash } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

export const columnsIndex = [
    { label: "Judul", key: "judul" },
    { label: "Username", key: "username" }
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

            if (!route().has('galeri-admin.show')) {
                alert("Route galeri-admin.show tidak tersedia!");
                return;
            }

            const url = route("galeri-admin.show", { galeri_admin: item.uuid }); 
            console.log("Navigating to:", url);
            router.visit(url);
        }
    }
    // {
    //     label: "Edit",
    //     icon: Edit,
    //     handler: (item) => {
    //         router.visit(route("galeri-admin.edit", item.uuid));
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