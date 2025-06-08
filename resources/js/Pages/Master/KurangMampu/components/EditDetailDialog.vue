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
    NumberField,
    NumberFieldContent,
    NumberFieldDecrement,
    NumberFieldIncrement,
    NumberFieldInput,
} from "@/components/ui/number-field";
import { Label } from "@/components/ui/label";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { CurrencyInput } from "@/components/ui/currency-input";
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
        jumlah_tanggungan: "",
        pendapatan_per_hari: "",
        pendapatan_per_bulan: "",
        keterangan: "",
    },
});

const jumlah_tanggungan = computed({
    get: () => values.jumlah_tanggungan,
    set: (val) => setValues({ jumlah_tanggungan: val }),
});

const pendapatan_per_hari = computed({
    get: () => values.pendapatan_per_hari,
    set: (val) => setValues({ pendapatan_per_hari: val }),
});

const pendapatan_per_bulan = computed({
    get: () => values.pendapatan_per_bulan,
    set: (val) => setValues({ pendapatan_per_bulan: val }),
});

const keterangan = computed({
    get: () => values.keterangan,
    set: (val) => setValues({ keterangan: val }),
});

const { editDataDetails, isLoading } = useKurangMampu();

const onSubmit = handleSubmit(async (formValues) => {
    await editDataDetails(props.initialData.uuid, formValues);
    emit("success");
});

watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen) {
            setValues({
                jumlah_tanggungan: props.initialData.jumlah_tanggungan || "",
                pendapatan_per_hari: props.initialData.pendapatan_per_hari || "",
                pendapatan_per_bulan: props.initialData.pendapatan_per_bulan || "",
                keterangan: props.initialData.keterangan || "",
            });
        } else {
            resetForm();
        }
    },
    { immediate: true },
);
</script>

<template>
    <Dialog :open="props.isOpen" @update:open="emit('update:isOpen', $event)">
        <DialogContent class="sm:max-w-[425px]">
            <form @submit.prevent="onSubmit">
                <DialogHeader>
                    <DialogTitle>Ubah Detail Data</DialogTitle>
                    <DialogDescription>
                        Ubah detail data kurang mampu
                    </DialogDescription>
                </DialogHeader>

                <div class="grid gap-4 py-4">
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="jumlah_tanggungan" class="text-right">
                            Jumlah Tanggungan
                        </Label>
                        <div class="col-span-3">
                            <NumberField
                                :default-value="0"
                                :min="0"
                                v-model="jumlah_tanggungan"
                                placeholder="Jumlah Tanggungan"
                                class="w-full"
                                name="jumlah_tanggungan"
                            >
                                <NumberFieldContent>
                                    <NumberFieldDecrement />
                                    <NumberFieldInput />
                                    <NumberFieldIncrement />
                                </NumberFieldContent>
                            </NumberField>
                        </div>
                    </div>

                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="pendapatan_per_hari" class="text-right">
                            Pendapatan per Hari
                        </Label>
                        <div class="col-span-3">
                            <CurrencyInput
                                v-model="pendapatan_per_hari"
                                placeholder="Pendapatan per Hari"
                                class="w-full"
                                name="pendapatan_per_hari"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="pendapatan_per_bulan" class="text-right">
                            Pendapatan per Bulan
                        </Label>
                        <div class="col-span-3">
                            <CurrencyInput
                                v-model="pendapatan_per_bulan"
                                placeholder="Pendapatan per Bulan"
                                class="w-full"
                                name="pendapatan_per_bulan"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="keterangan" class="text-right">
                            Keterangan
                        </Label>
                        <div class="col-span-3">
                            <Textarea
                                v-model="keterangan"
                                placeholder="Keterangan"
                                class="w-full h-24"
                                name="keterangan"
                            />
                        </div>
                    </div>
                </div>

                <DialogFooter>
                    <Button type="submit" :disabled="isLoading">
                        Simpan Perubahan
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
