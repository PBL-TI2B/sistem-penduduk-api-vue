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
import Cookies from "js-cookie";

const { uuid } = usePage().props;

const fields = ref(getFields());
const fotoFile = ref(null);
const previewFoto = ref(null);
const isLoading = ref(true);
const user_id = ref(null);

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
        if (user_id.value) {
            formData.append("user_id", user_id.value);
        }
        await apiPost(`/galeri/${uuid}`, formData);
        resetForm();
        toast.success("Berhasil memperbarui data galeri");
        router.visit("/galeri");
    } catch (error) {
        useErrorHandler(error);
    }
});

onMounted(async () => {
    try {
        // Ambil user_id
        const userRes = await apiGet("/auth/me");
        user_id.value = userRes.data?.id;

        // Ambil data galeri
        const galeriRes = await apiGet(`/galeri/${uuid}`);
        const data = galeriRes.data;
        setValues({
            judul: data.judul,
        });
        if (data.url_media) {
            // Ambil gambar pakai axios (dengan token)
            const resImage = await axios.get(
                `/api/v1/galeri/url_media/${data.url_media}`,
                {
                    responseType: "blob",
                    headers: {
                        Authorization: `Bearer ${Cookies.get("token")}`,
                    },
                }
            );
            previewFoto.value = URL.createObjectURL(resImage.data);
        }
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data galeri");
    } finally {
        isLoading.value = false;
    }
});
</script>

<template>
    <Head title="Edit Galeri" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Edit Data Galeri</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/admin/dashboard' },
                { label: 'Galeri', href: '/admin/galeri' },
                { label: 'Edit Galeri' },
            ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <div v-if="isLoading" class="text-center py-12 text-gray-400">
            Memuat data...
        </div>
        <div v-else class="flex flex-col lg:flex-row gap-8 justify-between">
            <!-- Form Section -->
            <form @submit="onSubmit" class="space-y-6 w-full">
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
                <div>
                    <label class="block mb-2 font-medium">Foto Galeri</label>
                    <input
                        type="file"
                        accept="image/*"
                        class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg p-2"
                        @change="onFileChange"
                    />
                </div>

                <div class="flex justify-between items-center">
                    <p class="text-xs text-gray-500">
                        Peringatan: Pastikan data galeri sudah benar sebelum
                        disimpan.
                    </p>
                    <div class="flex gap-2 items-center">
                        <Button
                            @click="router.visit('/admin/galeri')"
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
                    v-if="previewFoto"
                    :src="previewFoto"
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
