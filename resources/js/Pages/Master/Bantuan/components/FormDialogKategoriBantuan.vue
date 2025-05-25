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
import { formSchemaKategori } from "../utils/form-schema";
import Input from "@/components/ui/input/Input.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
import { useKategoriBantuan } from "@/composables/useKategoriBantuan";

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
    validationSchema: formSchemaKategori,
    initialValues: {
        kategori: "",
        keterangan: "",
    },
});

const kategori = computed({
    get: () => values.kategori,
    set: (val) => setValues({ kategori: val }),
});

const keterangan = computed({
    get: () => values.keterangan,
    set: (val) => setValues({ keterangan: val }),
});

const { createAndEditKategori, isLoadingKategori } = useKategoriBantuan();

const onSubmit = handleSubmit(async (formValues) => {
    await createAndEditKategori(formValues, props, emit);
});

watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen && props.mode === "edit") {
            setValues({
                kategori: props.initialData.kategori || "",
                keterangan: props.initialData.keterangan || "",
            });
        } else if (isOpen && props.mode === "create") {
            setValues({
                kategori: "",
                keterangan: "",
            });
        } else if (!isOpen) {
            resetForm();
        }
    },
    { immediate: true },
);

const dialogTitle = computed(() =>
    props.mode === "create" ? "Tambah Kategori" : "Edit Kategori",
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
                                ? "Ubah data kategori"
                                : "Tambahkan data kategori baru"
                        }}
                    </DialogDescription>
                </DialogHeader>

                <div class="grid gap-4 py-4">
                    <!-- RT Selection -->
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="kategori" class="text-right"
                            >Kategori</Label
                        >
                        <div class="col-span-3">
                            <Input
                                v-model="kategori"
                                type="text"
                                placeholder="Kategori"
                                class="w-full"
                                name="kategori"
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
                    <Button type="submit" :disabled="isLoadingKategori">
                        {{
                            mode === "edit" ? "Simpan Perubahan" : "Tambah Data"
                        }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
