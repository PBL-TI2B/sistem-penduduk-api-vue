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
import { ref, onMounted, watch } from "vue";
import { apiPost, apiGet } from "@/utils/api";
import { router } from "@inertiajs/vue3";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";

const fields = ref(getFields());
const { handleSubmit, resetForm, setFieldValue, values } = useForm();

const thumbnailFile = ref(null);
const previewThumbnail = ref(null);
const user_id = ref(null);
const username = ref(""); // Untuk menampilkan nama penulis jika perlu

// Fungsi generate slug dari judul
function generateSlug(text) {
    return text
        .toString()
        .toLowerCase()
        .trim()
        .replace(/\s+/g, "-") // Replace spaces with -
        .replace(/[^\w\-]+/g, "") // Remove all non-word chars
        .replace(/\-\-+/g, "-"); // Replace multiple - with single -
}

const onFileChange = (e) => {
    const file = e.target.files?.[0] || null;
    thumbnailFile.value = file;
    setFieldValue("thumbnail", file);
    if (file) {
        previewThumbnail.value = URL.createObjectURL(file);
    } else {
        previewThumbnail.value = null;
    }
};

// Watch judul, update slug otomatis
watch(
    () => values.judul,
    (newJudul) => {
        setFieldValue("slug", generateSlug(newJudul || ""));
    }
);

// Ambil user_id dan username dari endpoint /auth/me
onMounted(async () => {
    try {
        const res = await apiGet("/auth/me");
        user_id.value = res.data?.id;
        username.value = res.data?.username || "";
        if (!user_id.value) {
            throw new Error("user_id tidak ditemukan di response /auth/me");
        }
        setFieldValue("status", "draft");
    } catch (error) {
        useErrorHandler(error, "Gagal mengambil user_id");
    }
});

const onSubmit = handleSubmit(async (values) => {
    try {
        const formData = new FormData();
        formData.append("judul", values.judul);
        formData.append("slug", generateSlug(values.judul));
        formData.append("konten", values.konten);
        formData.append("status", values.status);
        formData.append("jumlah_dilihat", 0);
        if (thumbnailFile.value) {
            formData.append("thumbnail", thumbnailFile.value);
        }
        if (user_id.value) {
            formData.append("user_id", user_id.value);
        }
        await apiPost("/berita", formData);
        resetForm();
        previewThumbnail.value = null;
        toast.success("Berhasil tambah data berita");
        router.visit("/berita");
    } catch (error) {
        useErrorHandler(error);
    }
});
</script>

<template>
    <Head title="Tambah Berita" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Tambah Data Berita</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/' },
                { label: 'Berita', href: '/berita' },
                { label: 'Tambah Data Berita' },
            ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <div class="flex flex-col lg:flex-row gap-8 justify-between">
            <!-- Form Section -->
            <form @submit="onSubmit" class="space-y-6 w-full">
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
                                v-if="
                                    field.type !== 'textarea' &&
                                    field.type !== 'select'
                                "
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
                                <option
                                    v-for="opt in field.options"
                                    :key="opt.value"
                                    :value="opt.value"
                                >
                                    {{ opt.label }}
                                </option>
                            </select>
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <!-- Upload Thumbnail Berita -->
                <div>
                    <label class="block mb-2 font-medium"
                        >Thumbnail Berita</label
                    >
                    <input
                        type="file"
                        accept="image/*"
                        class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg p-2"
                        @change="onFileChange"
                    />
                </div>

                <div class="flex justify-between items-center">
                    <p class="text-xs text-gray-500">
                        Peringatan: Pastikan data berita sudah benar sebelum
                        disimpan.
                    </p>
                    <div class="flex gap-2 items-center">
                        <Button
                            @click="router.visit('/berita')"
                            type="button"
                            variant="secondary"
                            >Batal</Button
                        >
                        <Button type="submit">Simpan</Button>
                    </div>
                </div>
            </form>

            <!-- Preview Section -->
            <div class="flex items-center justify-center">
                <img
                    v-if="previewThumbnail"
                    :src="previewThumbnail"
                    alt="Preview"
                    class="rounded-md w-[400px] h-[300px] object-cover border"
                />
                <img
                    v-else
                    src="https://placehold.co/400x300?text=No+Image"
                    alt="No Preview"
                    class="rounded-md w-[400px] h-[300px] object-cover border"
                />
            </div>
        </div>
    </div>
</template>
