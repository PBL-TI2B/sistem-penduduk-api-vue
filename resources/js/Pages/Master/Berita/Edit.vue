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
import { apiGet, apiPost } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { router, usePage } from "@inertiajs/vue3";
import { toast } from "vue-sonner";
import axios from "axios";
import Cookies from "js-cookie";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

const { slug } = usePage().props;
const fields = ref(getFields());
const thumbnailFile = ref(null);
const previewThumbnail = ref(null);
const user_id = ref(null);

const { handleSubmit, setValues, resetForm, setFieldValue, values } = useForm();

const onFileChange = (e) => {
    const file = e.target.files?.[0] || null;
    thumbnailFile.value = file;
    setFieldValue("thumbnail", file);
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
        formData.append("status", values.status);
        if (thumbnailFile.value) {
            formData.append("thumbnail", thumbnailFile.value);
        }
        if (user_id.value) {
            formData.append("user_id", user_id.value);
        }
        // Tambahkan log ini
        console.log("FormData:", [...formData.entries()]);
        await apiPost(`/berita/${slug}`, formData);
        resetForm();
        toast.success("Berhasil memperbarui data berita");
        router.visit("/admin/berita");
    } catch (error) {
        useErrorHandler(error);
    }
});

// Load data saat mount
onMounted(async () => {
    try {
        const beritaRes = await apiGet(`/berita/${slug}`);
        const data = beritaRes.data; // pastikan ambil data yang benar
        setValues({
            judul: data.judul ?? "",
            konten: data.konten ?? "",
            status: data.status && data.status !== "" ? data.status : "draft", // lebih aman
        });
        if (data.thumbnail) {
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
        const userRes = await apiGet("/auth/me");
        user_id.value = userRes.data?.id;
        if (!user_id.value) {
            throw new Error("user_id tidak ditemukan di response /auth/me");
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
                { label: 'Dashboard', href: '/admin/dashboard' },
                { label: 'Berita', href: '/admin/berita' },
                { label: 'Edit Berita' },
            ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <div class="flex flex-col lg:flex-row gap-8 justify-between">
            <form @submit.prevent="onSubmit" class="space-y-6 w-full">
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
                            <QuillEditor
                                v-else-if="field.type === 'textarea'"
                                theme="snow"
                                toolbar="full"
                                contentType="html"
                                style="min-height: 250px"
                                v-model:content="values[field.name]"
                                @update:content="
                                    setFieldValue(field.name, $event)
                                "
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
                            @click="router.visit('/admin/berita')"
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
