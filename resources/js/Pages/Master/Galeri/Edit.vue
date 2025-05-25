<script setup>
import {
    FormField,
    FormItem,
    FormLabel,
    FormControl,
    FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { useForm } from "vee-validate";
import { getFields } from "./utils/fields";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { ref, onMounted } from "vue";
import { apiGet, apiPost } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { router, usePage } from "@inertiajs/vue3";
import { toast } from "vue-sonner";

// Routing ID
const { uuid } = usePage().props;

const fields = ref(getFields());
const fotoFile = ref(null);
const previewFoto = ref(null);

const { handleSubmit, setValues, resetForm } = useForm();

const onFileChange = (e) => {
    const file = e.target.files?.[0] || null;
    fotoFile.value = file;
    if (file) {
        previewFoto.value = URL.createObjectURL(file);
    }
};

const onSubmit = handleSubmit(async (values) => {
    try {
        const formData = new FormData();
        formData.append("_method", "PUT");
        formData.append("judul", values.judul);
        if (fotoFile.value) {
            formData.append("url_media", fotoFile.value);
        }
        await apiPost(`/galeri/${uuid}`, formData);
        resetForm();
        toast.success("Berhasil memperbarui data galeri");
        router.visit("/galeri-admin");
    } catch (error) {
        useErrorHandler(error);
    }
});

// Load data saat mount
onMounted(async () => {
    try {
        const galeriRes = await apiGet(`/galeri/${uuid}`);
        const data = galeriRes.data;
        setValues({
            judul: data.judul,
        });
        if (data.url_media) {
            previewFoto.value = data.url_media.startsWith("http")
                ? data.url_media
                : `/storage/${data.url_media}`;
        }
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data galeri");
    }
});
</script>

<template>
    <Head title="Edit Galeri" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Edit Data Galeri</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/' },
                { label: 'Galeri', href: '/galeri-admin' },
                { label: 'Edit Galeri' },
            ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <form @submit="onSubmit" class="space-y-6 grid grid-cols-2 gap-x-8">
            <!-- Judul -->
            <FormField
                v-for="field in fields"
                :key="field.name"
                :name="field.name"
                v-slot="{ componentField }"
            >
                <FormItem v-if="field.name === 'judul'">
                    <FormLabel>{{ field.label }}</FormLabel>
                    <FormControl>
                        <Input
                            :type="field.type"
                            :placeholder="field.placeholder"
                            v-bind="componentField"
                        />
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>

            <!-- Upload Foto Galeri -->
            <div class="col-span-2">
                <label class="block mb-2 font-medium">Foto Galeri</label>
                <div class="flex items-start gap-8">
                    <input
                        type="file"
                        accept="image/*"
                        class="block w-full max-w-xs text-sm text-gray-600 border border-gray-300 rounded-lg p-2"
                        @change="onFileChange"
                    />
                    <div v-if="previewFoto" class="mt-0">
                        <img :src="previewFoto" alt="Preview" class="w-80 h-56 object-cover rounded shadow border" />
                    </div>
                </div>
            </div>

            <div class="flex col-span-2 justify-between items-center">
                <div>
                    <p>Peringatan: Pastikan data galeri sudah benar sebelum disimpan.</p>
                </div>
                <div class="flex gap-2 items-center">
                    <Button
                        @click="router.visit('/galeri-admin')"
                        type="button"
                        variant="secondary"
                    >Batal</Button>
                    <Button type="submit">Simpan</Button>
                </div>
            </div>
        </form>
    </div>
</template>