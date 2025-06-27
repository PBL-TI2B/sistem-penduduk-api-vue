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
import { ref, onMounted } from "vue";
import { apiGet, apiPost } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { router, usePage } from "@inertiajs/vue3";
import { toast } from "vue-sonner";
import axios from "axios";
import Cookies from "js-cookie";
import { formSchemaPenduduk } from "./utils/form-schema";
import { usePenduduk } from "@/composables/usePenduduk";

import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

// Routing ID
const { uuid } = usePage().props;

// File foto
const fotoFile = ref(null);
const previewFoto = ref(null);
const fields = ref([]);

const onFileChange = (e) => {
    const file = e.target.files?.[0] || null;
    fotoFile.value = file;
    if (file) {
        previewFoto.value = URL.createObjectURL(file);
    }
};

// Setup form
const { handleSubmit, setValues, resetForm } = useForm({
    validationSchema: formSchemaPenduduk,
});

const { editPenduduk } = usePenduduk();

// Submit edit
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
        formData.append("_method", "PUT");

        for (const [key, value] of Object.entries(values)) {
            formData.append(key, value ?? "");
        }

        if (fotoFile.value) {
            formData.append("foto", fotoFile.value);
        }

        await apiPost(`/penduduk/${uuid}`, formData);
        resetForm();

        toast.success("Berhasil memperbarui data");
        // router.visit("/penduduk");
        router.visit("../");
    } catch (error) {
        useErrorHandler(error);
    }
});

// Load saat mount
onMounted(async () => {
    try {
        const [pendudukRes, pekerjaanRes, pendidikanRes, ayahRes, ibuRes] =
            await Promise.all([
                apiGet(`/penduduk/${uuid}`),
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

        const data = pendudukRes.data;
        setValues({
            nik: data.nik,
            nama_lengkap: data.nama_lengkap,
            foto: null,
            jenis_kelamin: data.jenis_kelamin,
            tempat_lahir: data.tempat_lahir,
            tanggal_lahir: data.tanggal_lahir,
            agama: data.agama,
            gol_darah: data.gol_darah,
            status_perkawinan: data.status_perkawinan,
            tinggi_badan: data.tinggi_badan,
            status: data.status,
            pekerjaan_id: data.pekerjaan?.id?.toString() || "",
            pendidikan_id: data.pendidikan?.id?.toString() || "",
            ayah_id: data.ayah_id?.toString() || "",
            ibu_id: data.ibu_id?.toString() || "",
        });

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

        if (data.foto) {
            const [imageRes] = await Promise.all([
                axios.get(`/api/v1/penduduk/foto/${data.foto}`, {
                    responseType: "blob",
                    headers: {
                        Authorization: `Bearer ${Cookies.get("token")}`,
                    },
                }),
            ]);
            previewFoto.value = URL.createObjectURL(imageRes.data);
        }
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data penduduk");
    }
});
</script>

<template>
    <Head title="Edit Penduduk" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Edit Data Penduduk</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/admin/dashboard' },
                { label: 'Data Penduduk', href: '/admin/penduduk' },
                { label: 'Edit Penduduk' },
            ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <form @submit="onSubmit" class="space-y-6 grid grid-cols-2 gap-x-8">
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
            <div class="flex items-center gap-2">
                <div>
                    <img
                        v-if="previewFoto"
                        :src="previewFoto"
                        alt="Foto preview"
                        class="w-12 rounded-lg"
                    />
                    <img
                        v-else
                        src="https://placehold.co/300x400?text=No+Photo"
                        alt="No Photo"
                        class="rounded-md w-12 object-cover"
                    />
                </div>
                <div class="w-full">
                    <label class="block font-medium">Foto (Opsional)</label>
                    <input
                        type="file"
                        accept="image/*"
                        @change="onFileChange"
                        class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg p-2"
                    />
                </div>
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
