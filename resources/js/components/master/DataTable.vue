<script setup>
import {
    Table,
    TableHeader,
    TableBody,
    TableRow,
    TableHead,
    TableCell,
} from "@/components/ui/table";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import Button from "@/components/ui/button/Button.vue";
import { ChevronLeft, ChevronRight } from "lucide-vue-next";
import { computed, ref } from "vue";
import axios from "axios";
import { useErrorHandler } from "@/composables/useErrorHandler";
import Cookies from "js-cookie";
import Sheet from "@/components/ui/sheet/Sheet.vue";

const props = defineProps({
    items: Array,
    columns: Array,
    page: {
        type: Number,
        default: 1,
    },
    totalPages: {
        type: Number,
        default: 1,
    },
    totalData: {
        type: Number,
        default: 0,
    },
    perPage: {
        type: Number,
        default: 10,
    },
    actions: {
        type: Array,
        default: () => [],
    },
    isLoading: {
        type: Boolean,
        default: false,
    },
    exportRoute: {
        type: String,
        default: "",
    },
    isExportable: {
        type: Boolean,
        default: false,
    },
    label: {
        type: String,
        default: "",
    },
});

const emit = defineEmits(["update:page"]);

const visiblePages = computed(() => {
    const total = props.totalPages;
    const current = props.page;
    const range = [];

    if (total <= 7) {
        for (let i = 1; i <= total; i++) range.push(i);
    } else {
        if (current <= 4) {
            range.push(1, 2, 3, 4, 5, "...", total);
        } else if (current >= total - 3) {
            range.push(
                1,
                "...",
                total - 4,
                total - 3,
                total - 2,
                total - 1,
                total
            );
        } else {
            range.push(
                1,
                "...",
                current - 1,
                current,
                current + 1,
                "...",
                total
            );
        }
    }

    return range;
});

const exportFormat = ref("");

const handleExport = async (format) => {
    try {
        const response = await axios.get(
            `/api/v1/${props.exportRoute}/export/${format}`,
            {
                responseType: "blob",
                headers: {
                    Authorization: `Bearer ${Cookies.get("token")}`,
                },
            }
        );

        const fileExtension = format === "pdf" ? "pdf" : "xlsx";
        const filename = `data-${props.exportRoute}.${fileExtension}`;

        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", filename);
        document.body.appendChild(link);
        link.click();
        link.remove();
    } catch (error) {
        useErrorHandler(error, "Gagal mengunduh file, silakan coba lagi");
    }
};
</script>

<template>
    <div class="bg-primary-foreground p-4 rounded-lg overflow-x-auto">
        <div class="flex justify-between items-center">
            <div class="flex gap-4">
                <div class="grid">
                    <h1 class="text-lg font-bold">
                        {{ props.label }}
                    </h1>
                    <p class="text-sm text-gray-600">
                        Total {{ props.totalData }} data
                    </p>
                </div>
                <Select
                    v-if="isExportable"
                    v-model="exportFormat"
                    @update:modelValue="handleExport"
                >
                    <SelectTrigger class="bg-primary-foreground">
                        <SelectValue placeholder="Export" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Export Ke</SelectLabel>
                            <SelectItem value="pdf">
                                <FileText />
                                Pdf
                            </SelectItem>
                            <SelectItem value="excel">
                                <Sheet /> Excel
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>
            <div class="flex gap-2 justify-end items-center">
                <Button
                    :disabled="page <= 1"
                    variant="ghost"
                    @click="emit('update:page', page - 1)"
                >
                    <ChevronLeft />
                </Button>
                <Button
                    v-for="n in visiblePages"
                    :key="n"
                    @click="typeof n === 'number' && emit('update:page', n)"
                    :disabled="n === '...'"
                    :class="[
                        'w-[30px] h-[30px] border rounded-md',
                        page === n
                            ? 'bg-primary text-primary-foreground'
                            : 'bg-muted',
                        n === '...' ? 'cursor-default' : 'cursor-pointer',
                    ]"
                    size="sm"
                    >{{ n }}</Button
                >
                <Button
                    :disabled="page === totalPages"
                    variant="ghost"
                    @click="emit('update:page', page + 1)"
                >
                    <ChevronRight />
                </Button>
            </div>
        </div>
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>No.</TableHead>
                    <TableHead v-for="col in columns" :key="col.key">
                        {{ col.label }}
                    </TableHead>
                    <TableHead v-if="actions.length">Aksi</TableHead>
                </TableRow>
            </TableHeader>

            <TableBody>
                <!-- Skeleton Loading -->
                <TableRow
                    v-if="isLoading"
                    v-for="i in perPage"
                    :key="'skeleton-' + i"
                >
                    <TableCell v-for="n in columns.length + 1" :key="n">
                        <div
                            class="h-9 bg-card/20 rounded animate-pulse w-full"
                        ></div>
                    </TableCell>
                </TableRow>

                <!-- Jika tidak loading dan tidak ada data -->
                <TableRow v-else-if="items.length === 0">
                    <TableCell :colspan="columns.length + 2">
                        <p
                            class="text-center w-full py-6 text-muted-foreground font-semibold"
                        >
                            Data tidak ditemukan.
                        </p>
                    </TableCell>
                </TableRow>

                <!-- Data Rows -->
                <TableRow
                    v-else
                    v-for="(item, index) in items"
                    :key="item.uuid || item.id"
                >
                    <!-- Nomor -->
                    <TableCell>
                        {{ (page - 1) * perPage + index + 1 }}
                    </TableCell>

                    <!-- Isi kolom -->
                    <TableCell v-for="col in columns" :key="col.key">
                        <span
                            :class="
                                col.customClass
                                    ? `${col.customClass(
                                          item[col.key],
                                          item
                                      )} px-3 p-1 rounded-md`
                                    : ''
                            "
                        >
                            {{
                                col.format
                                    ? col.format(item[col.key], item)
                                    : item[col.key]
                            }}
                        </span>
                    </TableCell>

                    <!-- Aksi -->
                    <TableCell v-if="actions.length">
                        <Button
                            v-for="(action, index) in actions"
                            :key="index"
                            :variant="action.variant || 'secondary'"
                            @click="() => action.handler(item)"
                            class="mr-2 cursor-pointer"
                            :disabled="
                                typeof action.disabled === 'function'
                                    ? action.disabled(item)
                                    : action.disabled
                            "
                        >
                            <component :is="action.icon" class="w-4 h-4" />
                            {{ action.label }}
                        </Button>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
