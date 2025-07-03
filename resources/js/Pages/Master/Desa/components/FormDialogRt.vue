<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { useForm, useField } from "vee-validate";
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
import Select from "@/components/ui/select/Select.vue";
import SelectContent from "@/components/ui/select/SelectContent.vue";
import SelectItem from "@/components/ui/select/SelectItem.vue";
import SelectTrigger from "@/components/ui/select/SelectTrigger.vue";
import SelectValue from "@/components/ui/select/SelectValue.vue";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { apiGet, apiPost } from "@/utils/api";
import { toast } from "vue-sonner";
import Input from "@/components/ui/input/Input.vue";
// Textarea is not used, can be removed
// import Textarea from "@/components/ui/textarea/Textarea.vue";

// Props dan Emits
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

// Load data dusun
const rwOptions = ref([]);

const loadRwOptions = async () => {
    try {
        // Always get all dusun for the dropdown
        const res = await apiGet("/rw?all=true");
        rwOptions.value = res.data.data;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data rw");
    }
};

// Setup form vee-validate
const { handleSubmit, resetForm, setValues } = useForm();

// [FIX] Define fields that match the template
const { value: nomor_rt } = useField("nomor_rt");
const { value: rw_id } = useField("rw_id", (value) =>
    value ? Number(value) : null
);

// Submit handler
const onSubmit = handleSubmit(async (formValues) => {
    console.log("Submitting these values:", formValues);
    try {
        const formData = new FormData();

        for (const [key, value] of Object.entries(formValues)) {
            formData.append(key, value ?? "");
        }

        if (props.mode === "edit") {
            formData.append("_method", "PUT");
            await apiPost(`/rt/${props.initialData?.uuid}`, formData);
        } else {
            await apiPost("/rt", formData);
        }

        toast.success(
            props.mode === "edit"
                ? "Berhasil memperbarui data RT"
                : "Berhasil menambahkan data RT"
        );

        emit("success");
        emit("update:isOpen", false);
    } catch (error) {
        // This will now catch validation errors from the backend
        console.error("Error submitting:", error);
        useErrorHandler(error, "Gagal menyimpan data RT");
    }
});

// Watch props.isOpen to reset or setValues
watch(
    () => props.isOpen,
    async (isOpen) => {
        if (isOpen) {
            await loadRwOptions();
            if (props.mode === "edit" && props.initialData) {
                // [FIX] Correctly set values for edit mode
                setValues({
                    nomor_rt: props.initialData.nomor_rt || "",
                    rw_id: props.initialData.rw
                        ? Number(props.initialData.rw.id)
                        : null,
                });
            } else {
                resetForm();
            }
        } else {
            resetForm();
        }
    },
    { immediate: true }
);

const dialogTitle = computed(() =>
    props.mode === "create" ? "Tambah RT" : "Edit RT"
);
</script>

<template>
    <Dialog :open="isOpen" @update:open="(val) => emit('update:isOpen', val)">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>{{ dialogTitle }}</DialogTitle>
                <DialogDescription>
                    Lengkapi form berikut untuk menyimpan data rt.
                </DialogDescription>
            </DialogHeader>

            <form @submit.prevent="onSubmit" class="space-y-4">
                <div class="space-y-2">
                    <Label for="nomor_rt">Nomor rt</Label>
                    <Input id="nomor_rt" v-model="nomor_rt" />
                </div>

                <div class="space-y-2">
                    <Label for="rw">Nomor RW</Label>
                    <Select v-model="rw_id">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Pilih RW" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem
                                v-for="rw in rwOptions"
                                :key="rw.id"
                                :value="rw.id"
                            >
                                {{ rw.nomor_rw }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                <DialogFooter>
                    <Button type="submit">Simpan</Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
