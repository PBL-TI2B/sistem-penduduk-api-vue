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
import {
    Select,
    SelectTrigger,
    SelectValue,
    SelectContent,
    SelectItem,
} from "@/components/ui/select";
import Label from "@/components/ui/label/Label.vue";
import { useKurangMampu } from "@/composables/useKurangMampu";

const props = defineProps({
    isOpen: Boolean,
    initialData: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(["update:isOpen", "success"]);

const { handleSubmit, resetForm, setValues, values } = useForm({
    initialValues: {
        status_validasi: "",
    },
});

const status_validasi = computed({
    get: () => values.status_validasi,
    set: (val) => setValues({ status_validasi: val }),
});

const isFormValid = computed(() => {
    return status_validasi.value !== "pending";
});

const { editStatusValidasi, isLoading } = useKurangMampu();

const onSubmit = handleSubmit(async (formValues) => {
    await editStatusValidasi(
        props.initialData.uuid,
        formValues.status_validasi
    );
    emit("success");
});

watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen) {
            setValues({
                status_validasi: props.initialData.status_validasi || "",
            });
        } else {
            resetForm();
        }
    },
    { immediate: true }
);
</script>

<template>
    <Dialog :open="props.isOpen" @update:open="emit('update:isOpen', $event)">
        <DialogContent class="sm:max-w-[425px]">
            <form @submit.prevent="onSubmit">
                <DialogHeader>
                    <DialogTitle>Ubah Status Validasi</DialogTitle>
                    <DialogDescription>
                        Ubah status validasi data kurang mampu
                    </DialogDescription>
                </DialogHeader>

                <div class="grid gap-4 py-4">
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="status_validasi" class="text-right">
                            Status Validasi
                        </Label>
                        <div class="col-span-3">
                            <Select v-model="status_validasi">
                                <SelectTrigger>
                                    <SelectValue
                                        placeholder="Status Validasi"
                                    />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="tervalidasi">
                                        Tervalidasi
                                    </SelectItem>
                                    <!-- <SelectItem value="pending">
                                        Pending
                                    </SelectItem> -->
                                    <SelectItem value="ditolak">
                                        Ditolak
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                    </div>
                </div>

                <DialogFooter>
                    <Button type="submit" :disabled="isLoading || !isFormValid">
                        Simpan Perubahan
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
