<script setup>
import {
    FormField,
    FormItem,
    FormLabel,
    FormControl,
    FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import {
    Select,
    SelectTrigger,
    SelectValue,
    SelectContent,
    SelectItem,
} from "@/components/ui/select";
import { Button } from "@/components/ui/button";
import { useForm } from "vee-validate";
import { getFields } from "./utils/fields";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { onMounted, ref } from "vue";
import { apiGet } from "@/utils/api";
import { router } from "@inertiajs/vue3";
import { formSchemaPenduduk } from "./utils/form-schema";
import { usePenduduk } from "@/composables/usePenduduk";

const fotoFile = ref(null);
const fields = ref([]);

const onFileChange = (e) => {
    const target = e.target;
    fotoFile.value = target.files?.[0] || null;
};

const { handleSubmit, resetForm } = useForm({
    validationSchema: formSchemaPenduduk,
});

const { createPenduduk } = usePenduduk();

const onSubmit = handleSubmit(async (values) =>
    createPenduduk(values, resetForm)
);

onMounted(async () => {
    const pekerjaanRes = await apiGet("/pekerjaan");
    const pendidikanRes = await apiGet("/pendidikan");

    const pekerjaanOptions = pekerjaanRes.data.data.map((item) => ({
        value: item.id.toString(),
        label: item.nama_pekerjaan,
    }));

    const pendidikanOptions = pendidikanRes.data.data.map((item) => ({
        value: item.id.toString(),
        label: item.jenjang,
    }));

    fields.value = getFields(pekerjaanOptions, pendidikanOptions);
});
</script>

<template>
    <Head title="Tambah Penduduk" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Tambah Data Penduduk</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/' },
                { label: 'Data Penduduk', href: '/penduduk' },
                { label: 'Tambah Data Penduduk' },
            ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <form @submit="onSubmit" class="space-y-6 grid grid-cols-2 gap-x-8">
            <!-- Loop all fields except foto -->
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
                            v-if="
                                field.type === 'text' || field.type === 'date'
                            "
                            :type="field.type"
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

            <!-- Upload Foto -->
            <div class="col-span-2">
                <label class="block mb-2 font-medium">Foto (Opsional)</label>
                <input
                    type="file"
                    accept="image/*"
                    class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg p-2"
                    @change="onFileChange"
                />
            </div>

            <div class="flex col-span-2 justify-between items-center">
                <div>
                    <p>Peringatan</p>
                </div>
                <div class="flex gap-2 items-center">
                    <Button
                        @click="router.visit('/penduduk')"
                        type="button"
                        variant="secondary"
                        >Batal</Button
                    >
                    <Button type="submit">Simpan</Button>
                </div>
            </div>
        </form>
    </div>
</template>
