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
import { getFields } from "./utils/fields";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { onMounted, ref } from "vue";
import { apiGet, apiPost } from "@/utils/api";
import { router } from "@inertiajs/vue3";
import { formSchemaPenduduk } from "./utils/form-schema";
import { usePenduduk } from "@/composables/usePenduduk";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";

import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const fotoFile = ref(null);
const fields = ref([]);

const onFileChange = (e) => {
    const target = e.target;
    fotoFile.value = target.files?.[0] || null;
};

const { handleSubmit, resetForm } = useForm({
    validationSchema: formSchemaPenduduk,
});

const { createPenduduk } = usePenduduk();

const onSubmit = handleSubmit(async (values) => {
    try {
        const rawTanggal = values.tanggal_lahir;
        const dateObj = new Date(rawTanggal);

        const formattedDate = dateObj
            .toISOString()
            .slice(0, 19)
            .replace("T", " ");
        values.tanggal_lahir = formattedDate;

        const formData = new FormData();
        for (const [key, value] of Object.entries(values)) {
            formData.append(key, value ?? "");
        }

        if (fotoFile.value) {
            formData.append("foto", fotoFile.value);
        }

        await apiPost("/penduduk", formData);

        resetForm();
        toast.success("Berhasil Tambah Data Penduduk");
        router.visit("/admin/penduduk");
    } catch (error) {
        useErrorHandler(error);
    }
});

onMounted(async () => {
    try {
        const [pekerjaanRes, pendidikanRes, ayahRes, ibuRes] =
            await Promise.all([
                apiGet("/pekerjaan"),
                apiGet("/pendidikan"),
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
});
</script>

<template>
    <Head title="Tambah Penduduk" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Tambah Data Penduduk</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/admin/dashboard' },
                { label: 'Data Penduduk', href: '/admin/penduduk' },
                { label: 'Tambah Data Penduduk' },
            ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <form @submit="onSubmit" class="space-y-6 grid grid-cols-2 gap-x-8">
            <!-- Loop all fields except foto -->
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
                                field.type === 'text' || field.type === 'date'
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
                        <Datepicker
                            v-else-if="field.type === 'datepicker'"
                            locale="id"
                            :enable-time-picker="false"
                            :format="'dd MMMM yyyy'"
                            v-bind="componentField"
                        />
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>

            <!-- Upload Foto -->
            <div class="col-span-2">
                <label class="block mb-2 font-medium">Foto (Opsional)</label>
                <input
                    type="file"
                    accept="image/*"
                    class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg p-2"
                    @change="onFileChange"
                />
            </div>

            <div class="flex col-span-2 justify-between items-center">
                <div>
                    <p>Peringatan</p>
                </div>
                <div class="flex gap-2 items-center">
                    <Button
                        @click="router.visit('/admin/penduduk')"
                        type="button"
                        variant="secondary"
                        >Batal</Button
                    >
                    <Button type="submit">Simpan</Button>
                </div>
            </div>
        </form>
    </div>
</template>

<style scoped>
:deep(.dp__cell_inner.dp__active_date) {
    background-color: oklch(0.31 0.0702 152.07) !important; /* biru */
    color: white !important;
    border-radius: 6px;
}

:deep(.dp__cell_inner.dp__today) {
    border: 2px solid oklch(0.31 0.0702 152.07); /* border biru */
    border-radius: 6px;
}

:deep(.dp__action_button) {
    background-color: oklch(0.31 0.0702 152.07); /* warna latar */
    color: white; /* warna teks */
    border-radius: 6px;
    border: none;
}

:deep(.dp__action_button:hover) {
    background-color: oklch(0.22 0.0049 158.96); /* saat hover */
}
</style>
