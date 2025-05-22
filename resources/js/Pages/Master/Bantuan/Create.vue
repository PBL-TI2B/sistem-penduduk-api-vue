<script setup>
import {
    FormField,
    FormItem,
    FormLabel,
    FormControl,
    FormMessage,
} from "@/components/ui/form";
import {
    Select,
    SelectTrigger,
    SelectValue,
    SelectContent,
    SelectItem,
} from "@/components/ui/select";
import { Input } from "@/components/ui/input";
import { Textarea } from '@/components/ui/textarea'
import { Button } from "@/components/ui/button";
import { useForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { onMounted, ref } from "vue";
import { apiPost, apiGet} from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { router } from "@inertiajs/vue3";
import { toast } from "vue-sonner";
import { getFields } from "./utils/fields"; // Import getFields
import { formSchemaBantuan } from "./utils/form-schema";


// Initialize fields from getFields
const fields = ref([]);

const { handleSubmit, resetForm } = useForm({ validationSchema: formSchemaBantuan });

const onSubmit = handleSubmit(async (values) => {
    try {
        const res = await apiPost("/bantuan", values); // API call to create new pekerjaan

        resetForm(); // Reset form fields after submission
        toast.success("Berhasil Tambah Data Bantuan");
        router.visit("/bantuan"); // Redirect to pekerjaan list
    } catch (error) {
        useErrorHandler(error); // Handle any errors
    }
});

onMounted(async () => {
    const kategoriBantuanRes = await apiGet("/kategori-bantuan");
    const kategoriBantuanOptions = kategoriBantuanRes.data.data.map((item) => ({
        value: item.id.toString(),
        label: item.kategori,
    }));
    fields.value = getFields(kategoriBantuanOptions);
});
</script>

<template>
    <Head title="Tambah Bantuan" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Tambah Data Pekerjaan</h1>
        <BreadcrumbComponent
            :items="[ { label: 'Dashboard', href: '/' }, { label: 'Data Bantuan', href: '/bantuan' }, { label: 'Tambah Data Bantuan' } ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <form @submit="onSubmit" class="space-y-6">
            <!-- Loop through fields -->
            <div class="space-y-6 grid grid-cols-2 gap-x-8">
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
                        <Textarea
                            v-if="field.type === 'textarea'"
                            :placeholder="field.placeholder"
                            v-bind="componentField"
                        />
                        <Select
                            v-else-if="field.type === 'select'"
                            v-bind="componentField"
                        >
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Pilih..." />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="option in field.options"
                                    :key="option.value || option"
                                    :value="option.value || option"
                                >
                                    {{ option.label || option }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </FormControl>
                    <FormMessage />
                    </FormItem>
                </FormField>
            </div>
            <!-- Submit Button -->
            <div class="flex justify-end gap-4">
                <Button
                        @click="router.visit('/bantuan')"
                        type="button"
                        variant="secondary"
                        >Batal</Button
                    >
                <Button type="submit" >Simpan</Button>
            </div>
        </form>
    </div>
</template>

