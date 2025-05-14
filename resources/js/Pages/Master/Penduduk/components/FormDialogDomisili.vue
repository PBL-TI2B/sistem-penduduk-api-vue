<script setup>
import { ref, computed, watch, onMounted } from "vue";
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
import Select from "@/components/ui/select/Select.vue";
import SelectContent from "@/components/ui/select/SelectContent.vue";
import SelectItem from "@/components/ui/select/SelectItem.vue";
import SelectTrigger from "@/components/ui/select/SelectTrigger.vue";
import SelectValue from "@/components/ui/select/SelectValue.vue";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { apiGet, apiPost } from "@/utils/api";
import { formSchmemaDomisili } from "../utils/form-schema";
import { toast } from "vue-sonner";
import Input from "@/components/ui/input/Input.vue";

// Data
const fields = ref([]);

// Props
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

// Emits
const emit = defineEmits(["update:isOpen", "success"]);

// Form Setup
const { handleSubmit, resetForm, setValues, values } = useForm({
    validationSchema: formSchmemaDomisili,
    initialValues: {
        penduduk_id: "",
        rt_id: "",
        status_tempat_tinggal: "",
    },
});

// Computed properties untuk binding Select
const selectedRt = computed({
    get: () => values.rt_id,
    set: (val) => setValues({ rt_id: val }),
});

const selectedStatus = computed({
    get: () => values.status_tempat_tinggal,
    set: (val) => setValues({ status_tempat_tinggal: val }),
});

const loadRtData = async () => {
    try {
        const res = await apiGet("/rt");
        fields.value = res.data.data;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data RT");
    }
};

const onSubmit = handleSubmit(async (formValues) => {
    try {
        const formData = new FormData();
        formData.append("penduduk_id", values.penduduk_id ?? "");

        for (const [key, value] of Object.entries(formValues)) {
            formData.append(key, value ?? "");
        }

        if (props.mode === "edit") {
            formData.append("_method", "PUT");
            await apiPost(
                `/domisili/${props.initialData?.domisili?.uuid}`,
                formData
            );
        } else {
            await apiPost("/domisili", formData);
        }

        emit("success");
        emit("update:isOpen", false);
        toast.success(
            props.mode === "edit"
                ? "Berhasil memperbarui data domisili"
                : "Berhasil menambahkan data domisili"
        );
    } catch (error) {

        useErrorHandler(error, "Gagal menyimpan data domisili");
    }
});

watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen && props.mode === "edit") {
            setValues({
                penduduk_id: props.initialData.id,
                rt_id: props.initialData.domisili?.rt_id || "",
                status_tempat_tinggal:
                    props.initialData.domisili?.status_tempat_tinggal || "",
            });
        } else if (isOpen && props.mode === "create") {
            setValues({
                penduduk_id: props.initialData.id,
                rt_id: "",
                status_tempat_tinggal: "",
            });
        } else if (!isOpen) {
            resetForm();
        }
    },
    { immediate: true }
);


onMounted(() => {
    loadRtData();
});

const dialogTitle = computed(() =>
    props.mode === "create" ? "Tambah Domisili" : "Edit Domisili"
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
                                ? "Ubah data domisili"
                                : "Tambahkan data domisili baru"
                        }}
                    </DialogDescription>
                </DialogHeader>

                <div class="grid gap-4 py-4">
                    <!-- RT Selection -->
                    <Input
                        type="hidden"
                        name="penduduk_id"
                        v-model="values.penduduk_id"
                    />
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="rt" class="text-right">RT</Label>
                        <div class="col-span-3">
                            <Select v-model="selectedRt">
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Pilih RT" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        v-for="rt in fields"
                                        :key="rt.id"
                                        :value="rt.id"
                                    >
                                        RT {{ rt.nomor_rt }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                    </div>

                    <!-- Status Selection -->
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="status" class="text-right">Status</Label>
                        <div class="col-span-3">
                            <Select v-model="selectedStatus">
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Pilih Status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="tetap">Tetap</SelectItem>
                                    <SelectItem value="sementara"
                                        >Sementara</SelectItem
                                    >
                                </SelectContent>
                            </Select>
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
