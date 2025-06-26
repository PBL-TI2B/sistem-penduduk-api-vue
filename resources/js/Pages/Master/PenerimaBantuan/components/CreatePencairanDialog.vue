<script setup>
import { computed, watch, ref } from "vue";
import { useForm } from "vee-validate";
import Button from "@/components/ui/button/Button.vue";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle, // Re-add DialogTitle import
} from "@/components/ui/dialog";
import Label from "@/components/ui/label/Label.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
import Datepicker from "@vuepic/vue-datepicker";
import AlertDialog from "@/components/master/AlertDialog.vue";
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

const { createData, editStatusPencairan, isLoading } = usePencairanBantuan();

const isConfirmDialogOpen = ref(false);
const newPencairanData = ref(null);

const onSubmit = handleSubmit(async (formValues) => {
    let formattedTanggalPenerimaan = null;
    if (formValues.tanggal_penerimaan) {
        // Pastikan itu adalah objek Date, lalu format ke YYYY-MM-DD
        const dateObj = new Date(formValues.tanggal_penerimaan);
        if (!isNaN(dateObj.getTime())) {
            // Periksa apakah tanggal valid
            formattedTanggalPenerimaan = dateObj.toISOString().split("T")[0]; // Ambil hanya bagian YYYY-MM-DD
        }
    }

    const payload = {
        ...formValues, // Pertahankan nilai form lainnya
        tanggal_penerimaan: formattedTanggalPenerimaan, // Timpa dengan tanggal yang sudah diformat
        penerima_bantuan_id: props.penerimaBantuanId,
    };

    const createdData = await createData(payload);

    if (createdData) {
        newPencairanData.value = createdData;
        emit("update:isOpen", false); // Close create dialog
        isConfirmDialogOpen.value = true; // Open confirmation dialog
    }
});

const handleConfirmPencairan = async () => {
    if (newPencairanData.value) {
        await editStatusPencairan(newPencairanData.value.uuid, "diterima");
    }
    isConfirmDialogOpen.value = false;
    emit("success");
};

const handleCancelPencairan = () => {
    isConfirmDialogOpen.value = false;
    emit("success");
};
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
    <div>
        <Dialog
            :open="props.isOpen"
            @update:open="emit('update:isOpen', $event)"
        >
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
                                Tanggal Pencairan
                            </Label>
                            <div class="col-span-3">
                                <Datepicker
                                    id="tanggal_penerimaan"
                                    locale="id"
                                    :enable-time-picker="false"
                                    :format="'dd MMMM yyyy'"
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
                        <Button
                            type="submit"
                            :disabled="isLoading || !isFormValid"
                        >
                            Simpan
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
        <AlertDialog
            v-model:isOpen="isConfirmDialogOpen"
            title="Konfirmasi Penyaluran Bantuan"
            description="Apakah bantuan ini langsung disalurkan kepada penerima? Jika konfirmasi, status akan diubah menjadi 'Diterima'."
            :onConfirm="handleConfirmPencairan"
            :onCancel="handleCancelPencairan"
        />
    </div>
</template>
