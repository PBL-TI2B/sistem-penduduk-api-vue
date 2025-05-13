import { Eye } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

const columnsIndex = [
    { label: "Kategori Bantuan", key: "kategori" },
    { label: "Keterangan", key: "keterangan",
        format: (value) => {
            return value? '' || null : '-';
        },
    },
];

const actionsIndex = [
    {
        label: "Manage",
        icon: Eye,
        handler: (item) => {
            router.visit(route("kategori-bantuan.show", item.uuid));
        },
    },
];

const rowsShow = [
    { label: "Kategori Bantuan", key: "kategori" },
    { label: "Keterangan", key: "keterangan",
        format: (value) => {
            return value?? '-';
        },
    },
];


export { columnsIndex, actionsIndex, rowsShow };
