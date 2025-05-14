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
import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { ref } from "vue";
import { apiPost } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { router } from "@inertiajs/vue3";
import { toast } from "vue-sonner";
import { getFields } from "./utils/fields"; // Import getFields

// Initialize fields from getFields
const fields = ref(getFields());

const formSchema = toTypedSchema(
    z.object({
        kategori: z.string(),
    })
);

const { handleSubmit, resetForm } = useForm({ validationSchema: formSchema });

const onSubmit = handleSubmit(async (values) => {
    try {
        const res = await apiPost("/kategori-bantuan", values); // API call to create new pekerjaan

        resetForm(); // Reset form fields after submission
        toast.success("Berhasil Tambah Data Kategori Bantuan");
        router.visit("/kategori-bantuan"); // Redirect to pekerjaan list
    } catch (error) {
        useErrorHandler(error); // Handle any errors
    }
});
</script>

<template>
    <Head title="Tambah Kategori Bantuan" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Tambah Data Pekerjaan</h1>
        <BreadcrumbComponent
            :items="[ { label: 'Dashboard', href: '/' }, { label: 'Data Bantuan', href: '/kategori-bantuan' }, { label: 'Tambah Data Kategori Bantuan' } ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <form @submit="onSubmit" class="space-y-6">
            <!-- Loop through fields -->
            <FormField
                v-for="field in fields"
                :key="field.name"
                :name="field.name"
                v-slot="{ componentField }"
            >
                <FormItem>
                    <FormLabel>{{ field.label }}</FormLabel>
                    <FormControl>
                        <Input
                            v-if="field.type === 'text'"
                            :placeholder="field.placeholder"
                            v-bind="componentField"
                        />
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>

            <!-- Submit Button -->
            <div>
                <Button type="submit" class="w-full">Simpan</Button>
            </div>
        </form>
    </div>
</template>

