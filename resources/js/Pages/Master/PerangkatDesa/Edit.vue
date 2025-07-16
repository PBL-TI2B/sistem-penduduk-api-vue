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
import { onMounted, ref, watch } from "vue";
import { apiGet, apiPost } from "@/utils/api";
import { router, usePage } from "@inertiajs/vue3";
import dayjs from "dayjs";
import { formSchemaPerangkatDesa } from "./utils/form-schema";
import { usePerangkatDesa } from "@/composables/usePerangkatDesa";
import { debounce } from "lodash";

const fields = ref([]);
const perangkatDesa = ref(null);
const { uuid } = usePage().props;
const customInputMode = ref({});

const searchPenduduk = ref("");
const pendudukOptions = ref([]);
const loadingPenduduk = ref(false);

const { handleSubmit, resetForm , setFieldValue, values} = useForm({
    validationSchema: formSchemaPerangkatDesa,
    initialValues: {},
});

const { editPerangkatDesa } = usePerangkatDesa(uuid);

const onSubmit = handleSubmit(async (values) => {
    editPerangkatDesa(values, resetForm);
});

watch(searchPenduduk, debounce(async (val) => {
    if (val.length < 2) {
        pendudukOptions.value = [];
        return;
    }
    loadingPenduduk.value = true;
    try {
        const res = await apiGet(`/penduduk?search=${val}`);
        pendudukOptions.value = res.data.data.map((p) => ({
            value: p.id.toString(),
            label: p.nama_lengkap,
        }));
    } catch {
        pendudukOptions.value = [];
    }
    loadingPenduduk.value = false;
}, 500));

watch(searchPenduduk, (val) => {
    if (values.penduduk_id && val.length < 2) {
        setFieldValue("penduduk_id", "");
    }
});

const selectPenduduk = (option) => {
    setFieldValue("penduduk_id", option.value);
    searchPenduduk.value = option.label;
    pendudukOptions.value = [];
};

onMounted(async () => {
    const [
        pendudukRes,
        jabatanRes,
        periodeJabatanRes,
        desaRes,
        dusunRes,
        rtRes,
        rwRes,
    ] = await Promise.all([
        apiGet("/penduduk"),
        apiGet("/jabatan"),
        apiGet("/periode-jabatan"),
        apiGet("/desa"),
        apiGet("/dusun"),
        apiGet("/rt"),
        apiGet("/rw"),
    ]);

    const mapOptions = (data, labelKey) =>
        data.map((item) => ({
            value: item.id.toString(),
            label: item[labelKey],
        }));

    const penduduk = mapOptions(pendudukRes.data.data, "nama_lengkap");
    const jabatan = mapOptions(jabatanRes.data.data, "jabatan");
    const desa = mapOptions(desaRes.data.data, "nama");
    const dusun = mapOptions(dusunRes.data.data, "nama");
    const rt = mapOptions(rtRes.data.data, "nomor_rt");
    const rw = mapOptions(rwRes.data.data, "nomor_rw");

    const periodeJabatan = periodeJabatanRes.data.data.map((item) => ({
        value: item.id.toString(),
        label: `${dayjs(item.awal_menjabat).format("YYYY")} - ${dayjs(
            item.akhir_menjabat
        ).format("YYYY")}`,
    }));

    fields.value = getFields(
        penduduk,
        jabatan,
        periodeJabatan,
        desa,
        dusun,
        rt,
        rw
    );

    const res = await apiGet(`/perangkat-desa/${uuid}`);
    perangkatDesa.value = res.data;

    searchPenduduk.value = perangkatDesa.value.penduduk?.nama_lengkap || "";

    resetForm({
        values: {
            status_keaktifan: perangkatDesa.value.status_keaktifan,
            penduduk_id: perangkatDesa.value.penduduk?.id.toString(),
            jabatan_id: perangkatDesa.value.jabatan?.id.toString(),
            periode_jabatan_id:
                perangkatDesa.value.periode_jabatan?.id.toString(),
            desa_id: perangkatDesa.value.desa?.id.toString(),
            dusun_id: perangkatDesa.value.dusun?.id.toString(),
            rt_id: perangkatDesa.value.rt?.id.toString(),
            rw_id: perangkatDesa.value.rw?.id.toString(),
            // tambahkan field lainnya jika ada
        },
    });
});
</script>

<template>
    <Head title="Edit Perangkat Desa" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Edit Data Perangkat Desa</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/admin/dashboard' },
                { label: 'Data Perangkat Desa', href: '/admin/perangkat-desa' },
                { label: 'Edit Data Perangkat Desa' },
            ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <form @submit="onSubmit" class="space-y-6 grid grid-cols-2 gap-x-8">
                     <FormField name="penduduk_id" v-slot="{ errorMessage }">
                <FormItem>
                    <FormLabel>Nama Penduduk</FormLabel>
                    <FormControl>
                        <div class="autocomplete-wrapper" style="position: relative">
                            <Input
                                v-model="searchPenduduk"
                                placeholder="Ketik nama penduduk"
                                autocomplete="off"
                            />
                            <div
                                v-if="pendudukOptions.length > 0"
                                class="autocomplete-dropdown border rounded bg-white shadow mt-1 max-h-40 overflow-auto z-50"
                            >
                                <div v-if="loadingPenduduk" class="p-2 text-gray-500 text-center">
                                    Memuat data...
                                </div>
                                <div
                                    v-else-if="pendudukOptions.length"
                                    v-for="option in pendudukOptions"
                                    :key="option.value"
                                    class="p-2 hover:bg-blue-100 cursor-pointer"
                                    @click="selectPenduduk(option)"
                                >
                                    {{ option.label }}
                                </div>
                                <div
                                    v-else
                                    class="p-2 text-gray-500 text-center"
                                >
                                    Tidak ada hasil
                                </div>
                            </div>
                        </div>
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>    
            
            <FormField
                v-for="field in fields.filter(f => f.name !== 'penduduk_id')"
                :key="field.name"
                :name="field.name"
                v-slot="{ componentField }"
            >
                <FormItem>
                    <FormLabel>{{ field.label }}</FormLabel>
                    <FormControl>
                        <template v-if="field.type === 'selectOrInput'">
                            <div class="flex gap-2 items-center">
                                <template v-if="!customInputMode[field.name]">
                                    <Select v-bind="componentField">
                                        <SelectTrigger class="w-full">
                                            <SelectValue
                                                placeholder="Pilih..."
                                            />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem
                                                v-for="option in field.options"
                                                :key="option.value"
                                                :value="option.value"
                                            >
                                                {{ option.label }}
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                    <Button
                                        type="button"
                                        size="sm"
                                        variant="outline"
                                        @click="
                                            customInputMode[field.name] = true
                                        "
                                    >
                                        Input Manual
                                    </Button>
                                </template>
                                <template v-else>
                                    <Input
                                        type="text"
                                        placeholder="Contoh: 2024 - 2029"
                                        v-bind="componentField"
                                    />
                                    <Button
                                        type="button"
                                        size="sm"
                                        variant="outline"
                                        @click="
                                            customInputMode[field.name] = false
                                        "
                                    >
                                        Pilih dari Daftar
                                    </Button>
                                </template>
                            </div>
                        </template>

                        <!-- Default text & select fallback -->
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
                                    :key="option.value"
                                    :value="option.value"
                                >
                                    {{ option.label }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>

            <div class="flex col-span-2 justify-between items-center">
                <p>Pastikan semua data sudah benar sebelum menyimpan.</p>
                <div class="flex gap-2 items-center">
                    <Button
                        @click="router.visit('/admin/perangkat-desa')"
                        type="button"
                        variant="secondary"
                    >
                        Batal
                    </Button>
                    <Button type="submit">Simpan Perubahan</Button>
                </div>
            </div>
        </form>
    </div>
</template>
