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
import { computed } from "vue";

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
</script>

<template>
    <div class="bg-primary-foreground p-4 rounded-lg overflow-x-auto">
        <div class="flex justify-between items-center">
            <Select>
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
                        <SelectItem value="excel"> <Sheet /> Excel </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
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
                <TableRow
                    v-if="isLoading"
                    v-for="i in 10"
                    :key="'skeleton-' + i"
                >
                    <TableCell v-for="n in columns.length + 1" :key="n">
                        <div
                            class="h-9 bg-card/20 rounded animate-pulse w-full"
                        ></div>
                    </TableCell>
                </TableRow>

                <TableRow
                    v-else
                    v-for="(item, index) in items"
                    :key="item.uuid || item.id"
                >
                    <TableCell>{{
                        (page - 1) * perPage + index + 1
                    }}</TableCell>
                    <TableCell v-for="col in columns" :key="col.key">
                        {{
                            col.format
                                ? col.format(item[col.key], item)
                                : item[col.key]
                        }}
                    </TableCell>
                    <TableCell v-if="actions.length">
                        <Button
                            v-for="(action, index) in actions"
                            :key="index"
                            variant="ghost"
                            @click="() => action.handler(item)"
                            class="mr-2 cursor-pointer"
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
