<script setup>
import { Button } from "@/components/ui/button";
import { SquarePen, SquarePlus, Trash2 } from "lucide-vue-next";
import { rowsShow } from "../utils/tableDusun"; // Disarankan buat rows khusus dusun

const props = defineProps({
    items: {
        type: Object,
        required: true,
    },
    createdusunPenduduk: {
        type: Function,
        required: true,
    },
    editdusunPenduduk: {
        type: Function,
        required: true,
    },
    deletedusun: {
        type: Function,
        required: true,
    },
});
</script>

<template>
    <div class="shadow-md p-4 rounded-lg my-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold">Dusun Saat Ini</h2>
            <div class="flex gap-2">
                <Button
                    @click="createdusunPenduduk"
                    :disabled="items?.dusun?.id !== null"
                    variant="secondary"
                >
                    Tambah
                    <SquarePlus class="ml-1 w-4 h-4" />
                </Button>
                <Button
                    @click="editdusunPenduduk(items)"
                    :disabled="items?.dusun?.id === null"
                    variant="secondary"
                >
                    Ubah
                    <SquarePen class="ml-1 w-4 h-4" />
                </Button>
                <Button
                    @click="deletedusun"
                    :disabled="items?.dusun?.id === null"
                    variant="secondary"
                >
                    Hapus
                    <Trash2 class="ml-1 w-4 h-4" />
                </Button>
            </div>
        </div>

        <template v-if="items?.dusun?.id">
            <table class="w-full table-auto">
                <tbody>
                    <tr
                        v-for="row in rowsShow"
                        :key="row.key"
                        class="even:bg-card/30"
                    >
                        <td class="font-medium p-2 w-1/3">
                            {{ row.label }}
                        </td>
                        <td class="p-2">
                            {{
                                row.format
                                    ? row.format(items[row.key], items)
                                    : items[row.key]
                            }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </template>

        <template v-else>
            <p class="text-gray-500 p-4 italic">
                Belum ada data dusun saat ini.
            </p>
        </template>
    </div>
</template>
