<script setup>
import Button from "@/components/ui/button/Button.vue";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";
import Select from "@/components/ui/select/Select.vue";
import SelectContent from "@/components/ui/select/SelectContent.vue";
import SelectItem from "@/components/ui/select/SelectItem.vue";
import SelectTrigger from "@/components/ui/select/SelectTrigger.vue";
import SelectValue from "@/components/ui/select/SelectValue.vue";
import { computed, reactive, watch } from "vue";

const props = defineProps({
    isOpen: {
        type: Boolean,
        required: true,
    },
    mode: {
        type: String,
        default: "create",
    },
    initialData: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(["update:isOpen"]);

const form = reactive({
    rt: "",
    status: "",
});

watch(
    () => props.initialData,
    (data) => {
        form.rt = data.rt || "";
        form.status = data.status || "";
    },
    { immediate: true }
);

watch(
    () => props.isOpen,
    (open) => {
        if (!open) {
            Object.assign(form, {
                rt: "",
                status: "",
            });
        }
    }
);

const fields = {
    options: [
        { value: "1", label: "RT 01" },
        { value: "2", label: "RT 02" },
        { value: "3", label: "RT 03" },
        { value: "4", label: "RT 04" },
        { value: "5", label: "RT 05" },
    ],
};

const title = computed(() => (props.mode === "create" ? "Tambah" : "Ubah"));
</script>

<template>
    <Dialog :open="props.isOpen" @update:open="emit('update:isOpen', $event)">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>{{ title }} Domisili</DialogTitle>
                <DialogDescription>
                    {{
                        props.mode === "edit"
                            ? "Ubah domisili penduduk di bawah ini"
                            : "Isi domisili baru penduduk di bawah ini"
                    }}
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid items-center gap-4">
                    <Label for="name" class="text-right"> Pilih RT </Label>
                    <Select v-model="form.rt">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Pilih..." />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem
                                v-for="field in fields.options"
                                :key="field.value"
                                :value="field.value"
                            >
                                {{ field.label }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>
                <div class="grid items-center gap-4">
                    <Label for="name" class="text-right">
                        Status Tempat Tinggal
                    </Label>
                    <Select v-model="form.status">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Pilih..." />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="tetap"> Tetap </SelectItem>
                            <SelectItem value="sementara">
                                Sementara
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>
                <!-- <Input hidden id="penduduk_id" value="1" /> -->
            </div>
            <DialogFooter>
                <Button type="submit" @click="emit('save', { ...form })">
                    {{ props.mode === "edit" ? "Simpan Perubahan" : "Tambah" }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
