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
import { ref, onMounted, watch, onBeforeUnmount } from "vue";
import { apiGet, apiPost } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { router, usePage, Head } from "@inertiajs/vue3";
import { toast } from "vue-sonner";

// Import Tiptap dan ekstensinya (tanpa Image)
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import TextAlign from '@tiptap/extension-text-align';

const { slug } = usePage().props;
const fields = ref(getFields());
const { handleSubmit, setValues, resetForm, setFieldValue, values } = useForm();

const thumbnailFile = ref(null);
const previewThumbnail = ref(null);
const user_id = ref(null);

const editor = useEditor({
    content: '',
    extensions: [
        StarterKit,
        TextAlign.configure({ types: ['heading', 'paragraph'] }),
    ],
    editorProps: {
        attributes: {
            class: 'prose prose-sm dark:prose-invert max-w-none w-full border rounded-b-md p-2 focus:outline-none min-h-[300px]',
        },
    },
    onUpdate: () => {
        setFieldValue('konten', editor.value.getHTML());
    },
});

onBeforeUnmount(() => {
    if (editor.value) editor.value.destroy();
});

watch(() => values.konten, (newValue) => {
    if (editor.value && editor.value.getHTML() !== newValue) {
        editor.value.commands.setContent(newValue || '');
    }
});

const onFileChange = (e) => {
    const file = e.target.files?.[0] || null;
    thumbnailFile.value = file;
    setFieldValue("thumbnail", file);
    if (file) {
        previewThumbnail.value = URL.createObjectURL(file);
    }
};



const onSubmit = handleSubmit(async (formValues) => {
    try {
        const formData = new FormData();
        formData.append("_method", "PUT");
        formData.append("judul", formValues.judul);
        formData.append("konten", formValues.konten);
        formData.append("status", formValues.status);
        if (thumbnailFile.value) formData.append("thumbnail", thumbnailFile.value);
        if (user_id.value) formData.append("user_id", user_id.value);
        
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
        setValues({
            judul: data.judul ?? "",
            konten: data.konten ?? "",
            status: data.status && data.status !== "" ? data.status : "draft",
        });

        if (data.thumbnail) {
            previewThumbnail.value = `/storage/berita/${data.thumbnail}`;
        }

        const userRes = await apiGet("/auth/me");
        user_id.value = userRes.data?.id;
        if (!user_id.value) throw new Error("user_id tidak ditemukan");
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
                                v-if="field.type !== 'textarea' && field.type !== 'select'"
                                :type="field.type"
                                :placeholder="field.placeholder"
                                v-bind="componentField"
                            />
                            <div v-else-if="field.type === 'textarea' && editor">
                                <div class="border rounded-t-md p-2 flex gap-2 items-center flex-wrap bg-gray-50">
                                    <Button type="button" variant="outline" size="sm" @click="editor.chain().focus().toggleBold().run()" :class="{ 'bg-gray-200': editor.isActive('bold') }">Bold</Button>
                                    <Button type="button" variant="outline" size="sm" @click="editor.chain().focus().toggleItalic().run()" :class="{ 'bg-gray-200': editor.isActive('italic') }">Italic</Button>
                                    <Button type="button" variant="outline" size="sm" @click="editor.chain().focus().toggleStrike().run()" :class="{ 'bg-gray-200': editor.isActive('strike') }">Strike</Button>
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