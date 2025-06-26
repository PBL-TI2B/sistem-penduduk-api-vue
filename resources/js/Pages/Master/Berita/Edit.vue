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
import { ref, onMounted, nextTick } from "vue";
import { apiGet, apiPost } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { router, usePage, Head } from "@inertiajs/vue3";
import { toast } from "vue-sonner";

// Toast UI Editor
import "@toast-ui/editor/dist/toastui-editor.css";
import { Editor } from "@toast-ui/editor";

const { slug } = usePage().props;
const fields = ref(getFields());
const thumbnailFile = ref(null);
const previewThumbnail = ref(null);
const user_id = ref(null);

const { handleSubmit, setValues, resetForm, setFieldValue, values } = useForm();

// Editor refs
const editorRef = ref(null);
let editorInstance = null;

const onFileChange = (e) => {
    const file = e.target.files?.[0] || null;
    thumbnailFile.value = file;
    setFieldValue("thumbnail", file);
    if (file) {
        previewThumbnail.value = URL.createObjectURL(file);
    }
};

const initializeEditor = (initialContent = "") => {
    if (editorRef.value && !editorInstance) {
        editorInstance = new Editor({
            el: editorRef.value,
            height: "400px",
            initialEditType: "wysiwyg",
            previewStyle: "vertical",
            hideModeSwitch: true,
            usageStatistics: false,
            placeholder: "Edit konten berita di sini...",
            initialValue: initialContent,
            toolbarItems: [
                ["heading", "bold", "italic", "strike"],
                ["hr", "quote"],
                ["ul", "ol", "task", "indent", "outdent"],
                ["table", "image", "link"],
                ["code", "codeblock"],
                ["scrollSync"],
            ],
        });
    }
};

const onSubmit = handleSubmit(async (values) => {
    try {
        const content = editorInstance ? editorInstance.getMarkdown() : "";

        const formData = new FormData();
        formData.append("_method", "PUT");
        formData.append("judul", values.judul);
        formData.append("konten", content);
        formData.append("status", values.status);
        if (thumbnailFile.value) {
            formData.append("thumbnail", thumbnailFile.value);
        }
        if (user_id.value) {
            formData.append("user_id", user_id.value);
        }

        console.log("FormData:", [...formData.entries()]);
        await apiPost(`/berita/${slug}`, formData);
        resetForm();
        toast.success("Berhasil memperbarui data berita");
        router.visit("/admin/berita");
    } catch (error) {
        useErrorHandler(error);
    }
});

onMounted(async () => {
    try {
        const beritaRes = await apiGet(`/berita/${slug}`);
        const data = beritaRes.data;

        // Set form values
        setValues({
            judul: data.judul ?? "",
            status: data.status && data.status !== "" ? data.status : "draft",
        });

        // Set thumbnail preview
        if (data.thumbnail) {
            previewThumbnail.value = `/storage/berita/${data.thumbnail}`;
        }

        // Get user ID
        const userRes = await apiGet("/auth/me");
        user_id.value = userRes.data?.id;
        if (!user_id.value) {
            throw new Error("user_id tidak ditemukan di response /auth/me");
        }

        // Initialize editor with existing content after DOM is ready
        await nextTick();
        initializeEditor(data.konten ?? "");
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
                <!-- Other Fields (excluding konten and thumbnail) -->
                <FormField
                    v-for="field in fields.filter(
                        (f) => f.name !== 'konten' && f.name !== 'thumbnail'
                    )"
                    :key="field.name"
                    :name="field.name"
                    v-slot="{ componentField }"
                >
                    <FormItem>
                        <FormLabel>{{ field.label }}</FormLabel>
                        <FormControl>
                            <Input
                                v-if="field.type !== 'select'"
                                :type="field.type"
                                :placeholder="field.placeholder"
                                v-bind="componentField"
                            />
                            <select
                                v-else
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

                <!-- Toast UI Editor for Content -->
                <div>
                    <label class="block mb-2 font-semibold"
                        >Konten Berita</label
                    >
                    <div ref="editorRef" class="toast-ui-editor-wrapper"></div>
                </div>

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
                    <p class="text-xs text-gray-500 mt-1">
                        Kosongkan jika tidak ingin mengubah thumbnail
                    </p>
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
                        >
                            Batal
                        </Button>
                        <Button type="submit">Simpan Perubahan</Button>
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

<style scoped>
.toast-ui-editor-wrapper {
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    overflow: hidden;
}

/* Override Toast UI Editor styles if needed */
:deep(.toastui-editor-defaultUI) {
    border: none;
}

:deep(.toastui-editor-toolbar) {
    background-color: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}

:deep(.toastui-editor-md-container) {
    background-color: white;
}

:deep(.toastui-editor-preview-container) {
    background-color: #f9fafb;
}
</style>
