<script setup>
import { Button } from "@/components/ui/button";
import { SquarePen, SquarePlus, Trash2 } from "lucide-vue-next";
import { rowsShow } from "../utils/table";

defineProps({
    items: Object,
    createDomisiliPenduduk: Function,
    editDomisiliPenduduk: Function,
    deleteDomisili: Function,
});
</script>

<template>
    <div class="shadow-md p-2 rounded-lg flex gap-2 justify-between my-4">
        <div class="w-1/2">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold p-2">Domisili Saat Ini</h2>
                <div class="flex gap-2">
                    <Button
                        @click="createDomisiliPenduduk"
                        :disabled="items.domisili?.id !== null"
                        type="button"
                        variant="secondary"
                    >
                        Tambah
                        <SquarePlus />
                    </Button>
                    <Button
                        @click="editDomisiliPenduduk(items)"
                        :disabled="items.domisili?.id === null"
                        variant="secondary"
                    >
                        Ubah
                        <SquarePen />
                    </Button>
                    <Button
                        @click="deleteDomisili"
                        :disabled="items.domisili?.id === null"
                        variant="secondary"
                    >
                        Hapus
                        <Trash2 />
                    </Button>
                </div>
            </div>

            <template v-if="items.domisili?.id !== null">
                <table class="w-full gap-2 table">
                    <tr
                        v-for="row in rowsShow.slice(14)"
                        :key="row.key"
                        class="even:bg-card/30 p-2"
                    >
                        <td class="font-medium p-2">
                            {{ row.label }}
                        </td>
                        <td>
                            {{
                                row.format
                                    ? row.format(items[row.key], items)
                                    : items[row.key]
                            }}
                        </td>
                    </tr>
                </table>
            </template>

            <template v-else>
                <p class="text-gray-500 p-4">
                    Belum ada data domisili saat ini.
                </p>
            </template>
        </div>
    </div>
</template>
