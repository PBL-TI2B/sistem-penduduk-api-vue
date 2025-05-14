<script setup>
import { computed, watch } from "vue";
import { useForm } from "vee-validate";
import Button from "@/components/ui/button/Button.vue";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
import Label from "@/components/ui/label/Label.vue";
import { formSchmemaJabatan } from "../utils/form-schema";
import Input from "@/components/ui/input/Input.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
import { useJabatan } from "@/composables/useJabatan";

const props = defineProps({
    isOpen: Boolean,
    mode: {
        type: String,
        default: "create",
    },
    initialData: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(["update:isOpen", "success"]);

const { handleSubmit, resetForm, setValues, values } = useForm({
    validationSchema: formSchmemaJabatan,
    initialValues: {
        jabatan: "",
        keterengan: "",
    },
});

const jabatan = computed({
    get: () => values.jabatan,
    set: (val) => setValues({ jabatan: val }),
});

const keterangan = computed({
    get: () => values.keterangan,
    set: (val) => setValues({ keterangan: val }),
});

const { createAndEditJabatan } = useJabatan();

const onSubmit = handleSubmit(async (formValues) => {
    createAndEditJabatan(formValues, props, emit);
});

watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen && props.mode === "edit") {
            setValues({
                jabatan: props.initialData.jabatan || "",
                keterangan: props.initialData.keterangan || "",
            });
        } else if (isOpen && props.mode === "create") {
            setValues({
                jabatan: "",
                keterangan: "",
            });
        } else if (!isOpen) {
            resetForm();
        }
    },
    { immediate: true }
);

const dialogTitle = computed(() =>
    props.mode === "create" ? "Tambah Jabatan" : "Edit Jabatan"
);
</script>

<template>
    <Dialog :open="props.isOpen" @update:open="emit('update:isOpen', $event)">
        <DialogContent class="sm:max-w-[425px]">
            <form @submit.prevent="onSubmit">
                <DialogHeader>
                    <DialogTitle>{{ dialogTitle }}</DialogTitle>
                    <DialogDescription>
                        {{
                            mode === "edit"
                                ? "Ubah data jabatan"
                                : "Tambahkan data jabatan baru"
                        }}
                    </DialogDescription>
                </DialogHeader>

                <div class="grid gap-4 py-4">
                    <!-- RT Selection -->
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="jabatan" class="text-right">Jabatan</Label>
                        <div class="col-span-3">
                            <Input
                                v-model="jabatan"
                                type="text"
                                placeholder="Jabatan"
                                class="w-full"
                                name="jabatan"
                            />
                        </div>
                    </div>

                    <!-- Status Selection -->
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="keterangan" class="text-right"
                            >Keterangan</Label
                        >
                        <div class="col-span-3">
                            <Textarea
                                v-model="keterangan"
                                placeholder="Keterangan"
                                class="w-full h-24"
                                name="keterangan"
                            ></Textarea>
                        </div>
                    </div>
                </div>

                <DialogFooter>
                    <Button type="submit">
                        {{
                            mode === "edit" ? "Simpan Perubahan" : "Tambah Data"
                        }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
