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
import { apiPost, apiGet } from "@/utils/api";
import { router } from "@inertiajs/vue3";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";

const fields = ref(getFields());
const { handleSubmit, resetForm, setFieldValue } = useForm();

const fotoFile = ref(null);
const previewFoto = ref(null);
const user_id = ref(null);

const onFileChange = (e) => {
    const file = e.target.files?.[0] || null;
    fotoFile.value = file;
    setFieldValue("url_media", file);
    if (file) {
        previewFoto.value = URL.createObjectURL(file);
    } else {
        previewFoto.value = null;
    }
};

// Ambil user_id dari endpoint /me
onMounted(async () => {
    try {
        const res = await apiGet("/auth/me");
        console.log("RESPON /auth/me:", res);
        user_id.value = res.data?.id;
        if (!user_id.value) {
            throw new Error("user_id tidak ditemukan di response /auth/me");
        }
    } catch (error) {
        useErrorHandler(error, "Gagal mengambil user_id");
    }
});
const onSubmit = handleSubmit(async (values) => {
    try {
        const formData = new FormData();
        formData.append("judul", values.judul);
        if (fotoFile.value) {
            formData.append("url_media", fotoFile.value);
        }
        if (user_id.value) {
            formData.append("user_id", user_id.value);
        }
        await apiPost("/galeri", formData);
        resetForm();
        previewFoto.value = null;
        toast.success("Berhasil tambah data galeri");
        router.visit("/galeri-admin");
    } catch (error) {
        useErrorHandler(error);
    }
});
</script>

<template>
    <Head title="Tambah Galeri" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Tambah Data Galeri</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/' },
                { label: 'Galeri', href: '/galeri-admin' },
                { label: 'Tambah Data Galeri' },
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
                <input
                    type="file"
                    accept="image/*"
                    class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg p-2"
                    @change="onFileChange"
                />
                <div v-if="previewFoto" class="mt-2">
                    <img :src="previewFoto" alt="Preview" class="w-32 rounded shadow" />
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