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
import { usePenerimaBantuan } from "@/composables/usePenerimaBantuan";

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
        status: "",
    },
});

const status = computed({
    get: () => values.status,
    set: (val) => setValues({ status: val }),
});

const isFormValid = computed(() => {
    return status.value !== "belum tervalidasi";
});

const { editStatusPenerimaanBantuan, isLoading } = usePenerimaBantuan();

const onSubmit = handleSubmit(async (formValues) => {
    await editStatusPenerimaanBantuan(
        props.initialData.uuid,
        formValues.status
    );
    emit("success");
});

watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen) {
            setValues({
                status: props.initialData.status || "",
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
                    <DialogTitle>Ubah Status Bantuan</DialogTitle>
                    <DialogDescription>
                        Ubah validasi data bantuan
                    </DialogDescription>
                </DialogHeader>

                <div class="grid gap-4 py-4">
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="status" class="text-right">
                            Status Bantuan
                        </Label>
                        <div class="col-span-3">
                            <Select v-model="status">
                                <SelectTrigger>
                                    <SelectValue placeholder="Status Bantuan" />
                                </SelectTrigger>
                                <SelectContent>
                                    <!-- <SelectItem value="diajukan">
                                        Diajukan
                                    </SelectItem> -->
                                    <SelectItem value="aktif">
                                        Aktif
                                    </SelectItem>
                                    <SelectItem value="selesai">
                                        Selesai
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
