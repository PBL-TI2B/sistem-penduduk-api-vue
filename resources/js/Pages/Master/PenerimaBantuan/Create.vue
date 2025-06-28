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
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
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
import { formSchemaPenerimaBantuan } from "./utils/form-schema";
import { columnsIndexKurangMampu, columnsIndexBantuan } from "./utils/table";
import { useKurangMampu } from "@/composables/useKurangMampu";
import { usePenerimaBantuan } from "@/composables/usePenerimaBantuan";
import { useBantuan } from "@/composables/useBantuan";

const { createData, isLoading } = usePenerimaBantuan();

const {
    items: itemsKurangMampu,
    // item,
    isLoading: isLoadingKurangMampu,
    page: pageKurangMampu,
    perPage: perPageKurangMampu,
    totalPages: totalPagesKurangMampu,
    totalItems: totalItemsKurangMampu,
    search: searchKurangMampu,
    selectedStatusValidasi,
    // statusValidasiOptions,
    // imageUrl,
    fetchData: fetchDataKurangMampu,
    // fetchDetailData,
    // createData,
    // editData,
    // editStatusValidasi,
    // editDataDetails,
    // deleteData,
} = useKurangMampu();

const {
    items: itemsBantuan,
    // item,
    isLoading: isLoadingBantuan,
    page: pageBantuan,
    perPage: perPageBantuan,
    totalPages: totalPagesBantuan,
    totalData: totalDataBantuan,
    search: searchBantuan,
    statusBantuan,
    // selectedKategori,
    fetchBantuan: fetchDataBantuan,
    // fetchDetailBantuan,
    // createBantuan,
    // editBantuan,
    // deleteBantuan,
} = useBantuan();

// Initialize fields from getFields
const fields = ref([]);

const showForm = ref(false);

const { handleSubmit, resetForm, setFieldValue } = useForm({
    validationSchema: formSchemaPenerimaBantuan,
    // initialValues: {
    //     anggota_keluarga_id: "",
    //     jumlah_tanggungan: "",
    //     pendapatan_per_hari: null,
    //     pendapatan_per_bulan: null,
    //     keterangan: "",
    // },
});

const clearSearchKurangMampu = () => {
    searchKurangMampu.value = "";
    // fetchDataAnggotaKeluarga();
    fetchDataKurangMampu();
};

const clearSearchBantuan = () => {
    searchBantuan.value = "";
    // fetchDataAnggotaKeluarga();
    fetchDataBantuan();
};

const onSubmit = handleSubmit((values) => {
    console.log("Submit");
    createData(values);
    resetForm();
});

const actionPilihKurangMampu = [
    {
        label: "Pilih",
        icon: Eye,
        handler: (item) => {
            fields.value = getFields();
            // fields.value = getFields(item); // Masih dipakai untuk label/placeholder dll

            // Sinkronkan juga ke form (vee-validate)
            setFieldValue("nama_penduduk", item.penduduk.nama_lengkap);
            setFieldValue("kurang_mampu_id", item.id);
            // setFieldValue("jumlah_tanggungan", "");
            // setFieldValue("pendapatan_per_hari", null);
            // setFieldValue("pendapatan_per_bulan", null);
            // setFieldValue("keterangan", "");

            showForm.value = true;
        },
    },
];

const actionPilihBantuan = [
    {
        label: "Pilih",
        icon: Eye,
        handler: (item) => {
            fields.value = getFields();
            // // fields.value = getFields(item); // Masih dipakai untuk label/placeholder dll
            setFieldValue("nama_bantuan", item.nama_bantuan);
            setFieldValue("bantuan_id", item.id);
            showForm.value = true;
        },
    },
];

onMounted(() => {
    perPageBantuan.value = 5;
    perPageKurangMampu.value = 5;
    statusBantuan.value = "aktif";
    selectedStatusValidasi.value = "tervalidasi";
    fetchDataKurangMampu();
    fetchDataBantuan();
    // fields.value = getFields("-");
});
watch(pageKurangMampu, () => {
    // fetchDataAnggotaKeluarga();
    fetchDataKurangMampu();
});
watch(pageBantuan, () => {
    // fetchDataAnggotaKeluarga();
    fetchDataBantuan();
});
</script>

<template>
    <Head title="Tambah Kurang Mampu" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Tambah Data Penerima Bantuan</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/admin/dashboard' },
                {
                    label: 'Data Penerima Bantuan',
                    href: '/admin/penerima-bantuan',
                },
                { label: 'Tambah Data Penerima Bantuan' },
            ]"
        />
    </div>

    <div class="drop-shadow-md w-full grid gap-2 mb-3 mt-3">
        <!-- Search Kategori -->
        <div
            class="flex xl:flex-row flex-col bg-primary-foreground relative items-center p-2 rounded-lg gap-2 justify-between w-ful"
        >
            <Input
                id="searchKurangMampu"
                v-model="searchKurangMampu"
                type="text"
                placeholder="Cari penduduk kurang mampu"
                class="pl-10 pr-8"
                @change="fetchDataKurangMampu"
            />
            <span
                class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
            >
                <SearchIcon class="size-6 text-muted-foreground" />
            </span>
            <button
                v-if="searchKurangMampu"
                class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                @click="clearSearchKurangMampu"
                tabindex="-1"
                type="button"
            >
                <X class="size-5" />
            </button>
        </div>

        <DataTable
            label="Pilih Penduduk Kurang Mampu"
            :items="itemsKurangMampu"
            :columns="columnsIndexKurangMampu"
            :actions="actionPilihKurangMampu"
            :totalPages="totalPagesKurangMampu"
            :totalData="totalDataKurangMampu"
            :page="pageKurangMampu"
            :per-page="perPageKurangMampu"
            :is-loading="isLoadingKurangMampu"
            @update:page="pageKurangMampu = $event"
        />
    </div>

    <div class="drop-shadow-md w-full grid gap-2 mb-3 mt-3">
        <!-- Search Bantuan -->
        <div
            class="flex xl:flex-row flex-col bg-primary-foreground relative items-center p-2 rounded-lg gap-2 justify-between w-ful"
        >
            <Input
                id="searchKurangMampu"
                v-model="searchBantuan"
                type="text"
                placeholder="Cari penduduk kurang mampu"
                class="pl-10 pr-8"
                @change="fetchDataBantuan"
            />
            <span
                class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
            >
                <SearchIcon class="size-6 text-muted-foreground" />
            </span>
            <button
                v-if="searchBantuan"
                class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                @click="clearSearchBantuan"
                tabindex="-1"
                type="button"
            >
                <X class="size-5" />
            </button>
        </div>

        <DataTable
            label="Pilih Bantuan"
            :items="itemsBantuan"
            :columns="columnsIndexBantuan"
            :actions="actionPilihBantuan"
            :totalPages="totalPagesBantuan"
            :totalData="totalDataBantuan"
            :page="pageBantuan"
            :per-page="perPageBantuan"
            :is-loading="isLoadingBantuan"
            @update:page="pageBantuan = $event"
        />
    </div>

    <!-- <div class="shadow-md p-2 rounded-lg flex gap-2 justify-between my-4">
        <div class="w-full">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold p-2">
                    Detail Kurang Mampu
                    <Badge variant="outline">
                        {{ item.status_validasi }}
                    </Badge>
                </h2>
                <div class="flex gap-2">
                    <Button
                        @click="isEditStatusDialogOpen = true"
                        variant="secondary"
                    >
                        Ubah Status Validasi
                        <SquarePen />
                    </Button>
                    <Button
                        @click="isEditDetailDialogOpen = true"
                        variant="secondary"
                    >
                        Ubah Detail Data
                        <SquarePen />
                    </Button>
                </div>
            </div>

            <table class="w-full gap-2 table">
                <tr
                    v-for="row in rowsShow.slice(13)"
                    :key="row.key"
                    class="even:bg-card/30 p-2"
                >
                    <td class="font-medium p-2">
                        {{ row.label }}
                    </td>
                    <td>
                        {{
                            row.format
                                ? row.format(item[row.key], item)
                                : item[row.key]
                        }}
                    </td>
                </tr>
            </table>
        </div>
    </div> -->

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
                                :disabled="field.disabled"
                                :Readonly="field.readonly"
                            />
                            <Datepicker
                                v-else-if="field.type === 'datepicker'"
                                locale="id"
                                :enable-time-picker="false"
                                :format="'dd MMMM yyyy'"
                                v-bind="componentField"
                            />
                            <!-- <CurrencyInput
                                v-else-if="field.type === 'currency'"
                                v-bind="componentField"
                                :placeholder="field.placeholder"
                            /> -->
                            <Textarea
                                v-else-if="field.type === 'textarea'"
                                v-bind="componentField"
                                :placeholder="field.placeholder"
                            />
                            <!-- <NumberField
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
                            -->
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
