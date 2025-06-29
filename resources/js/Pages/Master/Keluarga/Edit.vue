<script setup>
import {
    FormField,
    FormItem,
    FormLabel,
    FormControl,
    FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import {
    Select,
    SelectTrigger,
    SelectValue,
    SelectContent,
    SelectItem,
} from "@/components/ui/select";
import { Button } from "@/components/ui/button";
import { useForm } from "vee-validate";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { ref, onMounted } from "vue";
import { apiGet, apiPost } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { router, usePage } from "@inertiajs/vue3";
import { toast } from "vue-sonner";
import { createFormSchema } from "./utils/form-schema";

import "@vuepic/vue-datepicker/dist/main.css";
import { getFields } from "./utils/fields";

// [IMPROVEMENT] Menambahkan loading state
const isLoading = ref(true);
const isSubmitting = ref(false);

// Routing ID
const { uuid } = usePage().props;

// File foto
const fields = ref([]);

// Setup form
const { handleSubmit, setValues, resetForm } = useForm({
    validationSchema: createFormSchema(uuid),
});

// Submit edit
const onSubmit = handleSubmit(async (values) => {
    isSubmitting.value = true;
    try {
        const formData = new FormData();
        formData.append("_method", "PUT");

        for (const [key, value] of Object.entries(values)) {
            formData.append(key, value ?? "");
        }

        await apiPost(`/kartu-keluarga/${uuid}`, formData);
        resetForm();

        toast.success("Berhasil memperbarui data");
        router.visit("/admin/keluarga");
    } catch (error) {
        useErrorHandler(error);
    } finally {
        isSubmitting.value = false;
    }
});

// Lifecycle
onMounted(async () => {
    isLoading.value = true;
    try {
        // Mengambil data RT dan data Kartu Keluarga secara bersamaan untuk efisiensi
        const [resRT, resKK] = await Promise.all([
            apiGet("/rt", { per_page: -1 }), // Asumsi -1 untuk mengambil semua data
            apiGet(`/kartu-keluarga/${uuid}`),
        ]);

        // Proses data RT
        const rtOptions = resRT.data.data.map((item) => ({
            value: item.id.toString(),
            label: item.nomor_rt,
        }));
        fields.value = [...getFields(rtOptions)];

        // [FIX] Mengambil data KK dari properti 'data'
        const kkData = resKK.data;
        if (!kkData) return;

        // [FIX] Mengisi form dengan data yang benar dan tipe data yang sesuai
        setValues({
            nomor_kk: kkData.nomor_kk,
            rt_id: kkData.rt.id ? kkData.rt.id.toString() : null, // [FIX] Konversi ke string untuk Select
            kode_pos: kkData.kode_pos,
            kelurahan: kkData.kelurahan,
            kecamatan: kkData.kecamatan,
            kabupaten: kkData.kabupaten,
            provinsi: kkData.provinsi,
        });
    } catch (error) {
        useErrorHandler(error, "Gagal mengambil data kartu keluarga.");
    } finally {
        isLoading.value = false;
    }
});
</script>

<template>
    <Head title="Edit Kartu Keluarga" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Edit Data Kartu Keluarga</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/admin/dashboard' },
                { label: 'Data Kartu Keluarga', href: '/admin/keluarga' },
                { label: 'Edit Kartu Keluarga' },
            ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <div v-if="isLoading" class="text-center py-10">
            <p>Memuat data form...</p>
        </div>

        <form
            v-else
            @submit.prevent="onSubmit"
            class="space-y-6 grid grid-cols-2 gap-x-8"
        >
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
                            v-if="['text', 'date'].includes(field.type)"
                            :type="field.type"
                            :placeholder="field.placeholder"
                            v-bind="componentField"
                        />
                        <Select
                            v-else-if="field.type === 'select'"
                            v-bind="componentField"
                        >
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Pilih..." />
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
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>

            <div class="flex col-span-2 justify-between items-center">
                <div>
                    <p>Peringatan</p>
                </div>
                <div class="flex gap-2 items-center">
                    <Button
                        @click="router.visit('/admin/keluarga')"
                        type="button"
                        variant="secondary"
                        >Batal</Button
                    >
                    <Button type="submit" :disabled="isSubmitting">
                        <span v-if="isSubmitting">Menyimpan...</span>
                        <span v-else>Simpan</span>
                    </Button>
                </div>
            </div>
        </form>
    </div>
</template>
