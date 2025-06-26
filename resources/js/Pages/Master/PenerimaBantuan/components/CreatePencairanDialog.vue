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
import Input from "@/components/ui/input/Input.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
import { usePencairanBantuan } from "@/composables/usePencairanBantuan";

const props = defineProps({
    isOpen: Boolean,
    penerimaBantuanId: {
        type: [Number, String],
        required: true,
    },
});

const emit = defineEmits(["update:isOpen", "success"]);

const { handleSubmit, resetForm, values, defineField } = useForm({
    initialValues: {
        tanggal_penerimaan: "",
        keterangan: "",
    },
});

const [tanggal_penerimaan] = defineField("tanggal_penerimaan");
const [keterangan] = defineField("keterangan");

const isFormValid = computed(() => {
    return !!values.tanggal_penerimaan;
});

const { createData, isLoading } = usePencairanBantuan();

const onSubmit = handleSubmit(async (formValues) => {
    await createData({
        ...formValues,
        penerima_bantuan_id: props.penerimaBantuanId,
    });
    emit("success");
});

watch(
    () => props.isOpen,
    (isOpen) => {
        if (!isOpen) {
            resetForm();
        }
    }
);
</script>

<template>
    <Dialog :open="props.isOpen" @update:open="emit('update:isOpen', $event)">
        <DialogContent class="sm:max-w-[425px]">
            <form @submit.prevent="onSubmit">
                <DialogHeader>
                    <DialogTitle>Cairkan Bantuan</DialogTitle>
                    <DialogDescription>
                        Formulir untuk mencatat riwayat pencairan bantuan.
                    </DialogDescription>
                </DialogHeader>

                <div class="grid gap-4 py-4">
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="tanggal_penerimaan" class="text-right">
                            Tanggal
                        </Label>
                        <div class="col-span-3">
                            <Input
                                id="tanggal_penerimaan"
                                type="date"
                                v-model="tanggal_penerimaan"
                            />
                        </div>
                    </div>
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="keterangan" class="text-right">
                            Keterangan
                        </Label>
                        <div class="col-span-3">
                            <Textarea
                                id="keterangan"
                                v-model="keterangan"
                                placeholder="Keterangan tambahan (opsional)"
                            />
                        </div>
                    </div>
                </div>

                <DialogFooter>
                    <Button type="submit" :disabled="isLoading || !isFormValid">
                        Simpan
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
