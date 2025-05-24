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
import { Textarea } from "@/components/ui/textarea";
import { CurrencyInput } from "@/components/ui/currency-input";
import { Button } from "@/components/ui/button";
import { useForm } from "vee-validate";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { onMounted, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { getFields } from "./utils/fields"; // Import getFields
import { formSchemaBantuan } from "./utils/form-schema";
import { useBantuan } from "@/composables/useBantuan";
import { useKategoriBantuan } from "@/composables/useKategoriBantuan";

const { createBantuan } = useBantuan();
const { itemsKategoriAll, fetchKategori } = useKategoriBantuan();

// Initialize fields from getFields
const fields = ref([]);

const { handleSubmit, resetForm } = useForm({
    validationSchema: formSchemaBantuan,
});

const onSubmit = handleSubmit(async (values) => {
    await createBantuan(values);
    resetForm(); // Reset form fields after submission
});

onMounted(async () => {
    await fetchKategori(true);
    fields.value = getFields(itemsKategoriAll);
});
</script>

<template>
    <Head title="Tambah Bantuan" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Tambah Data Bantuan</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/' },
                { label: 'Data Bantuan', href: '/bantuan' },
                { label: 'Tambah Data Bantuan' },
            ]"
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
                            <CurrencyInput
                                v-else-if="field.type === 'currency'"
                                v-bind="componentField"
                                :placeholder="field.placeholder"
                            />
                            <Textarea
                                v-else-if="field.type === 'textarea'"
                                v-bind="componentField"
                                :placeholder="field.placeholder"
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
                <Button type="submit">Simpan</Button>
            </div>
        </form>
    </div>
</template>
