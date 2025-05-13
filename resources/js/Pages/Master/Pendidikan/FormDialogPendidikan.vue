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

const emit = defineEmits(["update:isOpen", "save"]);

const form = reactive({
    jenjang: "",
});

watch(
    () => props.initialData,
    (data) => {
        form.jenjang = data.jenjang || "";
    },
    { immediate: true }
);

watch(
    () => props.isOpen,
    (open) => {
        if (!open) {
            Object.assign(form, {
                jenjang: "",
            });
        }
    }
);

const title = computed(() => (props.mode === "create" ? "Tambah" : "Ubah"));
</script>

<template>
    <Dialog :open="props.isOpen" @update:open="emit('update:isOpen', $event)">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>{{ title }} Pendidikan</DialogTitle>
                <DialogDescription>
                    {{
                        props.mode === "edit"
                            ? "Ubah data pendidikan di bawah ini"
                            : "Isi data pendidikan baru di bawah ini"
                    }}
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid items-center gap-4">
                    <Label for="jenjang" class="text-right">
                        Jenjang Pendidikan
                    </Label>
                    <Input
                        id="jenjang"
                        v-model="form.jenjang"
                        placeholder="Masukkan Jenjang Pendidikan"
                    />
                </div>
            </div>
            <DialogFooter>
                <Button type="submit" @click="emit('save', { ...form })">
                    {{ props.mode === "edit" ? "Simpan Perubahan" : "Tambah" }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>