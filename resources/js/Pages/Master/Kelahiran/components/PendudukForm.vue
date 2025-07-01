<script setup>
import { ref, onMounted, watch, computed } from "vue";
import { useForm, Form as VeeForm } from "vee-validate";
import { toast } from "vue-sonner";
import { router } from "@inertiajs/vue3";

import { apiGet } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { formSchemaPenduduk } from "../utils/form-schema";
import { getFields } from "../utils/fields";

import { Button } from "@/components/ui/button";
import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";

import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const props = defineProps({
    isLoading: {
        type: Boolean,
        default: false,
    },
    fotoPreview: {
        type: String,
        default: null,
    },
    fotoFile: {
        type: File,
        default: null,
    },
});

const emit = defineEmits(["submit", "update:fotoFile", "update:fotoPreview"]);

const fields = ref([]);

const { handleSubmit, values } = useForm({
    validationSchema: formSchemaPenduduk,
});

const isStep1Valid = computed(() => {
    // Validasi field wajib untuk step 1
    const requiredFields = [
        "nik",
        "nama_lengkap",
        "jenis_kelamin",
        "tempat_lahir",
        "tanggal_lahir",
        "agama",
        "gol_darah",
        "status_perkawinan",
        "tinggi_badan",
        "status",
        "pekerjaan_id",
        "pendidikan_id",
        "ayah_id",
        "ibu_id",
    ];
    return requiredFields.every(
        (field) => values[field] && values[field].toString().trim() !== ""
    );
});

const onFileChange = (e) => {
    const file = e.target.files?.[0];
    if (!file) {
        emit("update:fotoFile", null);
        emit("update:fotoPreview", null);
        return;
    }

    if (!file.type.match("image.*")) {
        toast.error("File harus berupa gambar");
        emit("update:fotoFile", null);
        emit("update:fotoPreview", null);
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        toast.error("Ukuran file maksimal 2MB");
        emit("update:fotoFile", null);
        emit("update:fotoPreview", null);
        return;
    }

    emit("update:fotoFile", file);
    const reader = new FileReader();
    reader.onload = (e) => emit("update:fotoPreview", e.target?.result);
    reader.readAsDataURL(file);
};

const loadSelectOptions = async () => {
    try {
        const [pekerjaanRes, pendidikanRes, ayahRes, ibuRes] =
            await Promise.all([
                apiGet("/pekerjaan", { per_page: 100 }),
                apiGet("/pendidikan", { per_page: 100 }),
                apiGet("/penduduk", {
                    jenis_kelamin: "L",
                    status_perkawinan: "kawin",
                    exclude_ayah: true,
                }),
                apiGet("/penduduk", {
                    jenis_kelamin: "P",
                    status_perkawinan: "kawin",
                    exclude_ibu: true,
                }),
            ]);

        const pekerjaanOptions = pekerjaanRes.data.data.map((item) => ({
            value: item.id.toString(),
            label: item.nama_pekerjaan,
        }));

        console.log(pekerjaanOptions);

        const pendidikanOptions = pendidikanRes.data.data.map((item) => ({
            value: item.id.toString(),
            label: item.jenjang,
        }));

        const ayahOptions = ayahRes.data.data.map((item) => ({
            value: item.id.toString(),
            label: item.nama_lengkap,
        }));

        const ibuOptions = ibuRes.data.data.map((item) => ({
            value: item.id.toString(),
            label: item.nama_lengkap,
        }));

        fields.value = [
            ...getFields(pekerjaanOptions, pendidikanOptions),
            {
                name: "ayah_id",
                label: "Nama Ayah",
                type: "select",
                options: ayahOptions,
                placeholder: "Pilih Ayah",
            },
            {
                name: "ibu_id",
                label: "Nama Ibu",
                type: "select",
                options: ibuOptions,
                placeholder: "Pilih Ibu",
            },
        ];
    } catch (error) {
        useErrorHandler(error);
    }
};

onMounted(loadSelectOptions);

const onSubmit = handleSubmit((values) => {
    const rawTanggal = values.tanggal_lahir;
    const dateObj = new Date(rawTanggal);

    const formattedDate = dateObj.toISOString().slice(0, 19).replace("T", " ");
    values.tanggal_lahir = formattedDate;
    emit("submit", values);
});
</script>

<template>
    <div class="shadow-lg px-8 py-4 my-4 rounded-lg">
        <form @submit.prevent="onSubmit" class="grid lg:grid-cols-2 gap-4 mt-4">
            <FormField
                v-for="field in fields"
                :key="field.name"
                :name="field.name"
                v-slot="{ componentField }"
            >
                <FormItem>
                    <FormLabel>{{ field.label }}</FormLabel>
                    <FormControl>
                        <Input
                            v-if="
                                ['text', 'date', 'email'].includes(field.type)
                            "
                            :type="field.type"
                            :placeholder="field.placeholder"
                            v-bind="componentField"
                        />
                        <Select
                            v-else-if="field.type === 'select'"
                            v-bind="componentField"
                        >
                            <SelectTrigger class="w-full">
                                <SelectValue :placeholder="field.label" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="option in field.options"
                                    :key="option.value || option"
                                    :value="option.value || option"
                                >
                                    {{ option.label || option }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <Datepicker
                            v-else-if="field.type === 'datepicker'"
                            locale="id"
                            :enable-time-picker="false"
                            :format="'dd MMMM yyyy'"
                            :model-value="componentField.modelValue"
                            @update:model-value="
                                componentField['onUpdate:modelValue']
                            "
                        />
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>

            <!-- Foto -->
            <div class="col-span-2">
                <label class="block mb-2 font-medium">Foto (Opsional)</label>
                <input
                    type="file"
                    accept="image/*"
                    class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg p-2"
                    @change="onFileChange"
                />
                <div v-if="fotoPreview" class="mt-2">
                    <img
                        :src="fotoPreview"
                        alt="Foto Preview"
                        class="h-32 w-32 object-cover rounded"
                    />
                </div>
            </div>

            <div class="col-span-2 w-full justify-end flex gap-2">
                <Button
                    type="button"
                    @click="router.visit('/admin/kelahiran')"
                    variant="outline"
                >
                    Batal
                </Button>
                <Button type="submit" :disabled="isLoading || !isStep1Valid">
                    <span v-if="isLoading">Memproses...</span>
                    <span v-else>Selanjutnya</span>
                </Button>
            </div>
        </form>
    </div>
</template>

<style scoped>
:deep(.dp__cell_inner.dp__active_date) {
    background-color: oklch(0.31 0.0702 152.07) !important;
    color: white !important;
    border-radius: 6px;
}

:deep(.dp__cell_inner.dp__today) {
    border: 2px solid oklch(0.31 0.0702 152.07);
    border-radius: 6px;
}

:deep(.dp__action_button) {
    background-color: oklch(0.31 0.0702 152.07);
    color: white;
    border-radius: 6px;
    border: none;
}

:deep(.dp__action_button:hover) {
    background-color: oklch(0.22 0.0049 158.96);
}
</style>
