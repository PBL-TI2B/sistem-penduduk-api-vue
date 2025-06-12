<script setup>
import { useForm } from "vee-validate";

import { formSchemaKelahiran } from "./utils/form-schema";
import { fieldsKelahiran } from "./utils/fields";

import { Button } from "@/components/ui/button";
import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";

import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { useErrorHandler } from "@/composables/useErrorHandler";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { usePage } from "@inertiajs/vue3";
import { useKelahiran } from "@/composables/useKelahiran";
import { onMounted, ref } from "vue";

const { uuid } = usePage().props;
const emit = defineEmits(["submit", "back"]);
const isLoading = ref(false);

const { handleSubmit: kelahiranForm, setValues } = useForm({
    validationSchema: formSchemaKelahiran,
});

const { editData, fetchDetailData } = useKelahiran();

const handleSubmit = kelahiranForm(async (values) => {
    const rawTanggal = values.waktu_kelahiran;
    const dateObj = new Date(rawTanggal);

    const formattedDate = dateObj.toISOString().slice(0, 19).replace("T", " ");
    values.waktu_kelahiran = formattedDate;
    await editData(uuid, values);
});

onMounted(async () => {
    try {
        const res = await fetchDetailData(uuid);
        if (!res) return;
        setValues({
            penduduk_id: res.penduduk_id,
            anak_ke: Number(res.anak_ke),
            panjang: Number(res.panjang),
            berat: Number(res.berat),
            lokasi: res.lokasi,
            waktu_kelahiran: new Date(res.waktu_kelahiran),
            keterangan: res.keterangan,
        });
    } catch (error) {
        // useErrorHandler("Gagal mengambil data kelahiran.");
    }
});
</script>

<template>
    <Head title="Edit Kelahiran" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Edit Data Kelahiran</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/admin/dashboard' },
                { label: 'Data Kelahiran', href: '/admin/kelahiran' },
                { label: 'Edit Kelahiran' },
            ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <form
            @submit.prevent="handleSubmit"
            class="grid lg:grid-cols-2 gap-4 mt-4"
        >
            <FormField
                v-for="field in fieldsKelahiran"
                :key="field.name"
                :name="field.name"
                v-slot="{ componentField }"
            >
                <FormItem>
                    <FormLabel>{{ field.label }}</FormLabel>
                    <FormControl>
                        <Input
                            v-if="
                                field.type === 'text' ||
                                field.type === 'number' ||
                                field.type === 'date'
                            "
                            :type="field.type"
                            :placeholder="field.placeholder"
                            v-bind="componentField"
                        />
                        <Datepicker
                            v-else-if="field.type === 'datepicker'"
                            locale="id"
                            :enable-time-picker="true"
                            :format="'dd MMMM yyyy HH:mm'"
                            v-bind="componentField"
                        />
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>

            <div class="col-span-2 flex gap-2 w-full justify-end">
                <Button type="submit" :disabled="isLoading">
                    <span v-if="isLoading">Menyimpan...</span>
                    <span v-else>Simpan</span>
                </Button>
            </div>
        </form>
    </div>
</template>

<style scoped>
:deep(.dp__cell_inner.dp__active_date) {
    background-color: oklch(0.31 0.0702 152.07) !important; /* biru */
    color: white !important;
    border-radius: 6px;
}

:deep(.dp__cell_inner.dp__today) {
    border: 2px solid oklch(0.31 0.0702 152.07); /* border biru */
    border-radius: 6px;
}

:deep(.dp__action_button) {
    background-color: oklch(0.31 0.0702 152.07); /* warna latar */
    color: white; /* warna teks */
    border-radius: 6px;
    border: none;
}

:deep(.dp__action_button:hover) {
    background-color: oklch(0.22 0.0049 158.96); /* saat hover */
}
</style>
