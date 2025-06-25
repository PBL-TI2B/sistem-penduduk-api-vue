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
import { ref, onMounted, onBeforeUnmount } from "vue";
import { apiPost, apiGet } from "@/utils/api";
import { router } from "@inertiajs/vue3";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";
import { Head } from '@inertiajs/vue3';

// Import Tiptap dan ekstensinya (tanpa Image)
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import TextAlign from '@tiptap/extension-text-align';

const fields = ref(getFields());
const { handleSubmit, resetForm, setFieldValue } = useForm();

const thumbnailFile = ref(null);
const previewThumbnail = ref(null);
const user_id = ref(null);

// Setup Tiptap Editor (tanpa ekstensi Image)
const editor = useEditor({
    content: '',
    extensions: [
        StarterKit,
        TextAlign.configure({
            types: ['heading', 'paragraph'],
        }),
    ],
    editorProps: {
        attributes: {
            class: 'prose prose-sm dark:prose-invert max-w-none w-full border rounded-b-md p-2 focus:outline-none min-h-[300px]',
        },
    },
    onUpdate: ({ editor }) => {
        setFieldValue('konten', editor.getHTML());
    },
});

// Hancurkan editor untuk menghindari memory leak
onBeforeUnmount(() => {
    if (editor.value) {
        editor.value.destroy();
    }
});

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

onMounted(async () => {
    try {
        const res = await apiGet("/auth/me");
        user_id.value = res.data?.id;
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
        formData.append("konten", values.konten || '');
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
                            <div v-else-if="field.name === 'konten' && editor">
                                <div class="border rounded-t-md p-2 flex gap-2 items-center flex-wrap bg-gray-50">
                                    <Button type="button" variant="outline" size="sm" @click="editor.chain().focus().toggleBold().run()" :class="{ 'bg-gray-200': editor.isActive('bold') }">Bold</Button>
                                    <Button type="button" variant="outline" size="sm" @click="editor.chain().focus().toggleItalic().run()" :class="{ 'bg-gray-200': editor.isActive('italic') }">Italic</Button>
                                    <Button type="button" variant="outline" size="sm" @click="editor.chain().focus().toggleStrike().run()" :class="{ 'bg-gray-200': editor.isActive('strike') }">Strike</Button>
                                    <Button type="button" variant="outline" size="sm" @click="editor.chain().focus().setParagraph().run()" :class="{ 'bg-gray-200': editor.isActive('paragraph') }">Paragraph</Button>
                                    <Button type="button" variant="outline" size="sm" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'bg-gray-200': editor.isActive('heading', { level: 2 }) }">H2</Button>
                                    <Button type="button" variant="outline" size="sm" @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'bg-gray-200': editor.isActive('bulletList') }">List</Button>
                                    <div class="flex gap-1">
                                        <Button type="button" variant="outline" size="sm" @click="editor.chain().focus().setTextAlign('left').run()" :class="{ 'bg-gray-200': editor.isActive({ textAlign: 'left' }) }">Left</Button>
                                        <Button type="button" variant="outline" size="sm" @click="editor.chain().focus().setTextAlign('center').run()" :class="{ 'bg-gray-200': editor.isActive({ textAlign: 'center' }) }">Center</Button>
                                        <Button type="button" variant="outline" size="sm" @click="editor.chain().focus().setTextAlign('right').run()" :class="{ 'bg-gray-200': editor.isActive({ textAlign: 'right' }) }">Right</Button>
                                        <Button type="button" variant="outline" size="sm" @click="editor.chain().focus().setTextAlign('justify').run()" :class="{ 'bg-gray-200': editor.isActive({ textAlign: 'justify' }) }">Justify</Button>
                                    </div>
                                </div>
                                <EditorContent :editor="editor" />
                            </div>
                            <select
                                v-else-if="field.type === 'select'"
                                class="w-full border rounded p-2"
                                v-bind="componentField"
                            >
                                <option value="" disabled>Pilih status</option>
                                <option v-for="opt in field.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
                            </select>
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <div>
                    <label class="block mb-2 font-medium">Thumbnail Berita</label>
                    <input type="file" accept="image/*" class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg p-2" @change="onFileChange"/>
                </div>

                <div class="flex justify-between items-center">
                    <p class="text-xs text-gray-500">Pastikan data berita sudah benar sebelum disimpan.</p>
                    <div class="flex gap-2 items-center">
                        <Button @click="router.visit('/admin/berita')" type="button" variant="secondary">Batal</Button>
                        <Button type="submit">Simpan</Button>
                    </div>
                </div>
            </form>

            <div class="flex items-center justify-center">
                <img v-if="previewThumbnail" :src="previewThumbnail" alt="Preview" class="rounded-md w-[400px] h-[300px] object-cover border"/>
                <img v-else src="https://placehold.co/400x300?text=No+Image" alt="No Preview" class="rounded-md w-[400px] h-[300px] object-cover border"/>
            </div>
        </div>
    </div>
</template>