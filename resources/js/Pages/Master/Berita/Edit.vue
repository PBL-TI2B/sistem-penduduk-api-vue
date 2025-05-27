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
import axios from "axios";
import Cookies from "js-cookie";

const { uuid } = usePage().props;

const fields = ref(getFields());
const thumbnailFile = ref(null);
const previewThumbnail = ref(null);

const { handleSubmit, setValues, resetForm } = useForm();

const onFileChange = (e) => {
    const file = e.target.files?.[0] || null;
    thumbnailFile.value = file;
    if (file) {
        previewThumbnail.value = URL.createObjectURL(file);
    }
};

const onSubmit = handleSubmit(async (values) => {
    try {
        const formData = new FormData();
        formData.append("_method", "PUT");
        formData.append("judul", values.judul);
        formData.append("konten", values.konten);
        formData.append("tanggal_post", values.tanggal_post);
        formData.append("status", values.status);
        if (thumbnailFile.value) {
            formData.append("thumbnail", thumbnailFile.value);
        }
        await apiPost(`/berita/${uuid}`, formData);
        resetForm();
        toast.success("Berhasil memperbarui data berita");
        router.visit("/berita-admin");
    } catch (error) {
        useErrorHandler(error);
    }
});

// Load data saat mount
onMounted(async () => {
    try {
        const beritaRes = await apiGet(`/berita/${uuid}`);
        const data = beritaRes.data;
        setValues({
            judul: data.judul,
            konten: data.konten,
            tanggal_post: data.tanggal_post,
            status: data.status,
        });
        if (data.thumbnail) {
            // Ambil gambar pakai axios (dengan token jika perlu)
            const resImage = await axios.get(
                `/api/v1/berita/thumbnail/${data.thumbnail}`,
                {
                    responseType: "blob",
                    headers: {
                        Authorization: `Bearer ${Cookies.get("token")}`,
                    },
                }
            );
            previewThumbnail.value = URL.createObjectURL(resImage.data);
        }
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data berita");
    }
});
</script>

<template>
    <Head title="Edit Berita" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Edit Data Berita</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/' },
                { label: 'Berita', href: '/berita-admin' },
                { label: 'Edit Berita' },
            ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <form @submit="onSubmit" class="space-y-6 grid grid-cols-2 gap-x-8">
            <!-- Judul, Konten, Tanggal, Status -->
            <FormField
                v-for="field in fields"
                :key="field.name"
                :name="field.name"
                v-slot="{ componentField }"
            >
                <FormItem v-if="field.name !== 'thumbnail'">
                    <FormLabel>{{ field.label }}</FormLabel>
                    <FormControl>
                        <Input
                            v-if="field.type !== 'textarea' && field.type !== 'select'"
                            :type="field.type"
                            :placeholder="field.placeholder"
                            v-bind="componentField"
                        />
                        <textarea
                            v-else-if="field.type === 'textarea'"
                            :placeholder="field.placeholder"
                            class="w-full border rounded p-2"
                            v-bind="componentField"
                        />
                        <select
                            v-else-if="field.type === 'select'"
                            class="w-full border rounded p-2"
                            v-bind="componentField"
                        >
                            <option value="" disabled>Pilih status</option>
                            <option v-for="opt in field.options" :key="opt.value" :value="opt.value">
                                {{ opt.label }}
                            </option>
                        </select>
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>

            <!-- Upload Thumbnail Berita -->
            <div class="col-span-2">
                <label class="block mb-2 font-medium">Thumbnail Berita</label>
                <div class="flex items-start gap-8">
                    <input
                        type="file"
                        accept="image/*"
                        class="block w-full max-w-xs text-sm text-gray-600 border border-gray-300 rounded-lg p-2"
                        @change="onFileChange"
                    />
                    <div class="mt-0">
                        <img v-if="previewThumbnail" :src="previewThumbnail" alt="Preview" class="w-80 h-56 object-cover rounded shadow border" />
                        <img v-else src="https://placehold.co/400x300?text=No+Image" alt="No Preview" class="w-80 h-56 object-cover rounded shadow border" />
                    </div>
                </div>
            </div>

            <div class="flex col-span-2 justify-between items-center">
                <div>
                    <p>Peringatan: Pastikan data berita sudah benar sebelum disimpan.</p>
                </div>
                <div class="flex gap-2 items-center">
                    <Button
                        @click="router.visit('/berita-admin')"
                        type="button"
                        variant="secondary"
                    >Batal</Button>
                    <Button type="submit">Simpan</Button>
                </div>
            </div>
        </form>
    </div>
</template>