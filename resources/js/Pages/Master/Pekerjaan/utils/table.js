import { Eye } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

const columnsIndex = [
    { label: "Nama Pekerjaan", key: "nama_pekerjaan" },
];

const actionsIndex = [
    {
        label: "Manage",
        icon: Eye,
        handler: (item) => {
            router.visit(route("pekerjaan.show", item.uuid));
        },
    },
];

const rowsShow = [
    { label: "Nama Pekerjaan", key: "nama_pekerjaan" },
];

export { columnsIndex, actionsIndex, rowsShow };
