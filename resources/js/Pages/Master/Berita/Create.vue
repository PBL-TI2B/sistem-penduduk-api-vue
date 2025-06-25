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
import { apiPost, apiGet } from "@/utils/api";
import { router, Head } from "@inertiajs/vue3";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";

// Toast UI Editor
import "@toast-ui/editor/dist/toastui-editor.css";
import { Editor } from "@toast-ui/editor";

const fields = ref(getFields());
const { handleSubmit, resetForm, setFieldValue, values } = useForm();

const thumbnailFile = ref(null);
const previewThumbnail = ref(null);
const user_id = ref(null);
const username = ref("");

// Editor refs
const editorRef = ref(null);
let editorInstance = null;

const onFileChange = (e) => {
    const file = e.target.files?.[0] || null;
    thumbnailFile.value = file;
    setFieldValue("thumbnail", file);
    previewThumbnail.value = file ? URL.createObjectURL(file) : null;
};

const initializeEditor = () => {
    if (editorRef.value && !editorInstance) {
        editorInstance = new Editor({
            el: editorRef.value,
            height: "400px",
            initialEditType: "wysiwyg",
            previewStyle: "vertical",
            hideModeSwitch: true,
            usageStatistics: false,
            placeholder: "Tulis konten berita di sini...",
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

onMounted(async () => {
    try {
        const res = await apiGet("/auth/me");
        user_id.value = res.data?.id;
        username.value = res.data?.username || "";
        if (!user_id.value) throw new Error("user_id tidak ditemukan");
        setFieldValue("status", "draft");

        // Initialize editor after DOM is ready
        await nextTick();
        initializeEditor();
    } catch (error) {
        useErrorHandler(error, "Gagal mengambil user_id");
    }
});

const onSubmit = handleSubmit(async (values) => {
    try {
        const content = editorInstance ? editorInstance.getMarkdown() : "";

        const formData = new FormData();
        formData.append("judul", values.judul);
        formData.append("konten", content);
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

        // Reset editor content
        if (editorInstance) {
            editorInstance.setMarkdown("");
        }

        previewThumbnail.value = null;
        toast.success("Berhasil tambah data berita");
        router.visit("/admin/berita");
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
                { label: 'Dashboard', href: '/admin/dashboard' },
                { label: 'Berita', href: '/admin/berita' },
                { label: 'Tambah Data Berita' },
            ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <div class="flex flex-col lg:flex-row gap-8 justify-between">
            <form @submit="onSubmit" class="space-y-6 w-full">
                <!-- Other Fields (excluding konten) -->
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

                <!-- Toast UI Editor -->
                <div>
                    <label class="block mb-2 font-semibold"
                        >Konten Berita</label
                    >
                    <div ref="editorRef" class="toast-ui-editor-wrapper"></div>
                </div>

                <!-- Upload Thumbnail -->
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
                        >
                            Batal
                        </Button>
                        <Button type="submit">Simpan</Button>
                    </div>
                </div>
            </form>

            <!-- Preview Thumbnail -->
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
