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
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { ref, onMounted } from "vue";
import { apiPost, apiGet } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { router } from "@inertiajs/vue3";
import { toast } from "vue-sonner";
import { getFields } from "./utils/fields";
import { formSchemaKematian } from "./utils/form-schema";

const fields = ref(getFields());
const optionsMap = ref({});

const formSchema = toTypedSchema(formSchemaKematian);
const { handleSubmit, resetForm } = useForm({
    validationSchema: formSchema,
    initialValues: {
        penduduk_id: "",
        tanggal_kematian: "",
        sebab_kematian: "",
    },
});

const fetchOptions = async () => {
    for (const field of fields.value) {
        if (field.type === "select" && field.api) {
            try {
                const res = await apiGet(field.api);
                optionsMap.value[field.name] = res.data.data.map((item) => ({
                    label: item[field.optionLabel],
                    value: String(item[field.optionValue]),
                }));
            } catch (error) {
                useErrorHandler(error, `Gagal memuat opsi ${field.label}`);
            }
        }
    }
};

const onSubmit = handleSubmit(async (values) => {
    try {
        await apiPost("/kematian", values);
        toast.success("Berhasil menambahkan data kematian");
        resetForm();
        router.visit("/kematian");
    } catch (error) {
        useErrorHandler(error);
    }
});

onMounted(() => {
    fetchOptions();
});
</script>

<template>
    <Head title="Tambah Data Kematian" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Tambah Data Kematian</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/admin/dashboard' },
                { label: 'Data Kematian', href: '/admin/kematian' },
                { label: 'Tambah Data Kematian' },
            ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <form @submit.prevent="onSubmit" class="space-y-6" novalidate>
            <FormField
                v-for="field in fields"
                :key="field.name"
                :name="field.name"
                v-slot="{ componentField }"
            >
                <FormItem>
                    <FormLabel>{{ field.label }}</FormLabel>
                    <FormControl>
                        <template
                            v-if="
                                field.type === 'text' || field.type === 'date'
                            "
                        >
                            <Input
                                :type="field.type"
                                :placeholder="field.placeholder"
                                v-bind="componentField"
                            />
                        </template>

                        <template v-else-if="field.type === 'select'">
                            <select
                                class="w-full border rounded p-2"
                                :value="componentField.value"
                                @change="
                                    (e) =>
                                        componentField.handleChange(
                                            e.target.value
                                        )
                                "
                                @blur="componentField.handleBlur"
                            >
                                <option value="">-- Pilih --</option>
                                <option
                                    v-for="option in optionsMap[field.name] ||
                                    []"
                                    :key="option.value"
                                    :value="option.value"
                                >
                                    {{ option.label }}
                                </option>
                            </select>
                        </template>
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>

            <div>
                <Button type="submit" class="w-full">Simpan</Button>
            </div>
        </form>
    </div>
</template>
