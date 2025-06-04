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
import {
    NumberField,
    NumberFieldContent,
    NumberFieldDecrement,
    NumberFieldIncrement,
    NumberFieldInput,
} from "@/components/ui/number-field";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { CurrencyInput } from "@/components/ui/currency-input";
import { Button } from "@/components/ui/button";
import DataTable from "@/components/master/DataTable.vue";
import { useForm } from "vee-validate";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { onMounted, ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

import { PackagePlus, SearchIcon, X, FunnelX, Eye } from "lucide-vue-next";
import { getFields } from "./utils/fields"; // Import getFields
import { formSchemaKurangMampu } from "./utils/form-schema";
import { columnsIndexAnggotaKeluarga } from "./utils/table";
import { useKurangMampu } from "@/composables/useKurangMampu";
import { useAnggotaKeluarga } from "@/composables/useAnggotaKeluarga";

const { createData, isLoading } = useKurangMampu();

const {
    items,
    // item,
    isLoading: isLoadingAnggotaKeluarga,
    page,
    perPage,
    totalPages,
    totalData,
    search: searchPenduduk,
    fetchData: fetchDataAnggotaKeluarga,
    // fetchDetailData,
    // createData,
    // editData,
    // deleteData,
} = useAnggotaKeluarga();

// Initialize fields from getFields
const fields = ref([]);

const showForm = ref(false);

// const { handleSubmit, resetForm } = useForm({
//     validationSchema: formSchemaKurangMampu,
// });

const { handleSubmit, resetForm, setFieldValue } = useForm({
    validationSchema: formSchemaKurangMampu,
    initialValues: {
        anggota_keluarga_id: "",
        jumlah_tanggungan: "",
        pendapatan_per_hari: null,
        pendapatan_per_bulan: null,
        keterangan: "",
    },
});

const clearSearchPenduduk = () => {
    searchPenduduk.value = "";
    fetchDataAnggotaKeluarga();
};

const onSubmit = handleSubmit((values) => {
    console.log("Submit");
    createData(values);
    resetForm();
});

const actionPilihPenduduk = [
    {
        label: "Pilih",
        icon: Eye,
        handler: (item) => {
            fields.value = getFields(); // Masih dipakai untuk label/placeholder dll
            // fields.value = getFields(item); // Masih dipakai untuk label/placeholder dll

            // Sinkronkan juga ke form (vee-validate)
            setFieldValue("nama_penduduk", item.penduduk.nama_lengkap);
            setFieldValue("anggota_keluarga_id", item.id);
            // setFieldValue("jumlah_tanggungan", "");
            // setFieldValue("pendapatan_per_hari", null);
            // setFieldValue("pendapatan_per_bulan", null);
            // setFieldValue("keterangan", "");

            showForm.value = true;
        },
    },
];

onMounted(() => {
    fetchDataAnggotaKeluarga();
    // fields.value = getFields("-");
});
watch(page, () => {
    fetchDataAnggotaKeluarga();
});
</script>

<template>
    <Head title="Tambah KurangMampu" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Tambah Data Kurang Mampu</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/dashboard' },
                { label: 'Data Kurang Mampu', href: '/kurang-mampu' },
                { label: 'Tambah Data Kurang Mampu' },
            ]"
        />
    </div>

    <div class="drop-shadow-md w-full grid gap-2 mb-3 mt-3">
        <!-- Search Kategori -->
        <div
            class="flex xl:flex-row flex-col bg-primary-foreground relative items-center p-2 rounded-lg gap-2 justify-between w-ful"
        >
            <Input
                id="searchPenduduk"
                v-model="searchPenduduk"
                type="text"
                placeholder="Cari penduduk"
                class="pl-10 pr-8"
                @change="fetchDataAnggotaKeluarga"
            />
            <span
                class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
            >
                <SearchIcon class="size-6 text-muted-foreground" />
            </span>
            <button
                v-if="searchPenduduk"
                class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                @click="clearSearchPenduduk"
                tabindex="-1"
                type="button"
            >
                <X class="size-5" />
            </button>
        </div>

        <DataTable
            label="Pilih Penduduk"
            :items="items"
            :columns="columnsIndexAnggotaKeluarga"
            :actions="actionPilihPenduduk"
            :totalPages="totalPages"
            :totalData="totalData"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoadingAnggotaKeluarga"
            @update:page="page = $event"
        />
    </div>

    <!-- <div class="shadow-lg p-8 my-4 rounded-lg"> -->
    <div
        v-if="showForm"
        class="shadow-lg p-8 my-4 rounded-lg"
        :disabled="showForm === false"
    >
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
                                v-model="componentField.value"
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
                            <NumberField
                                v-else-if="field.type === 'number'"
                                v-bind="componentField"
                                :default-value="0"
                                :min="0"
                            >
                                <NumberFieldContent>
                                    <NumberFieldDecrement />
                                    <NumberFieldInput />
                                    <NumberFieldIncrement />
                                </NumberFieldContent>
                            </NumberField>
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
                            <!-- Hidden input to send value when field is hidden -->
                            <input
                                v-if="field.type === 'hidden'"
                                type="hidden"
                                :name="field.name"
                                v-model="componentField.value"
                                v-bind="componentField"
                            />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
            <!-- Submit Button -->
            <div class="flex justify-end gap-4">
                <Button type="submit" :disabled="isLoading">Simpan</Button>
            </div>
        </form>
    </div>
</template>
