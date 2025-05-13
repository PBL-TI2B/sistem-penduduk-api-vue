import { Eye, Pencil, Trash2 } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import { route } from "ziggy-js";

const columnsIndex = [
  {
    label: "Jenjang Pendidikan",
    key: "jenjang",
  },
  {
    label: "Dibuat",
    key: "created_at",
  },
  {
    label: "Diperbarui",
    key: "updated_at",
  },
];

const actionsIndex = [
  {
    label: "Edit",
    icon: Pencil,
    handler: (item) => {
      router.visit(route("pendidikan.edit", item.id));
    },
  },
  {
    label: "Hapus",
    icon: Trash2,
    handler: (item) => {
      if (confirm("Yakin ingin menghapus data ini?")) {
        router.delete(route("pendidikan.destroy", item.id));
      }
    },
  },
];

export { columnsIndex, actionsIndex };
