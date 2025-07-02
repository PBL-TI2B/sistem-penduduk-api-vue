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
import { getFieldDomisili, getFields } from "./utils/fields";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";

import { onMounted, ref, watch } from "vue";

import { apiGet, apiPost } from "@/utils/api";
import { router } from "@inertiajs/vue3";
import { formSchemaPenduduk } from "./utils/form-schema";
import { usePenduduk } from "@/composables/usePenduduk";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";

import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const fotoFile = ref(null);
const fields = ref([]);
const fieldsDomisili = ref([]);
const currentStep = ref(1);
const domisili = ref([]);
const pendudukId = ref(null);

const searchAyah = ref("");
const ayahOptions = ref([]);
const loadingAyah = ref(false);

const searchIbu = ref("");
const ibuOptions = ref([]);
const loadingIbu = ref(false);

const onFileChange = (e) => {
    const target = e.target;
    fotoFile.value = target.files?.[0] || null;
};

const { handleSubmit, resetForm, setFieldValue, values } = useForm({
    validationSchema: formSchemaPenduduk,
});

const { createPenduduk } = usePenduduk();

const isStep1Valid = computed(() => {
    // Validasi field wajib untuk step 1
    const requiredFields = [
        "nik",
        "nama_lengkap",
        "jenis_kelamin",
        "tempat_lahir",
        "tanggal_lahir",
        "agama",
        "status_perkawinan",
        "status",
        "pekerjaan_id",
        "pendidikan_id",
    ];
    return requiredFields.every(
        (field) => values[field] && values[field].toString().trim() !== ""
    );
});

const canProceedToStep2 = computed(() => {
    return isStep1Valid.value && pendudukId.value;
});

// Methods
const nextStep = async () => {
    if (currentStep.value === 1) {
        await submitStep1();
    } else if (currentStep.value === 2) {
        await submitStep2();
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
};

const submitStep1 = handleSubmit(async (values) => {
    try {
        const rawTanggal = values.tanggal_lahir;
        const dateObj = new Date(rawTanggal);

        const formattedDate = dateObj
            .toISOString()
            .slice(0, 19)
            .replace("T", " ");
        values.tanggal_lahir = formattedDate;

        const formData = new FormData();
        for (const [key, value] of Object.entries(values)) {
            formData.append(key, value ?? "");
        }

        if (fotoFile.value) {
            formData.append("foto", fotoFile.value);
        }

        const response = await apiPost("/penduduk", formData);
        pendudukId.value = response.data.id;

        toast.success("Data Penduduk berhasil disimpan");
        currentStep.value = 2;
    } catch (error) {
        if (error.response) {
            // Server responded with error status
            const { status, data } = error.response;
            console.log(status, data);

            if (status === 422) {
                // Check if data has direct field errors (not nested in errors object)
                if (data.nik) {
                    // Handle NIK error directly
                    const nikErrors = Array.isArray(data.nik)
                        ? data.nik
                        : [data.nik];
                    nikErrors.forEach((message) => {
                        toast.error(`NIK: ${message}`);
                    });
                } else if (data.errors) {
                    // Handle nested validation errors
                    Object.keys(data.errors).forEach((field) => {
                        const messages = data.errors[field];
                        messages.forEach((message) => {
                            toast.error(`${field}: ${message}`);
                        });
                    });
                } else if (data.message) {
                    toast.error(data.message);
                } else {
                    // Handle all direct field errors
                    Object.keys(data).forEach((field) => {
                        if (Array.isArray(data[field])) {
                            data[field].forEach((message) => {
                                toast.error(`${field}: ${message}`);
                            });
                        } else if (typeof data[field] === "string") {
                            toast.error(`${field}: ${data[field]}`);
                        }
                    });
                }
            } else if (status === 409) {
                // Conflict error (duplicate)
                toast.error(data.message || "NIK sudah terdaftar");
            } else {
                // Other server errors
                toast.error(data.message || "Terjadi kesalahan pada server");
            }
        } else if (error.request) {
            // Network error
            toast.error("Tidak dapat terhubung ke server");
        } else {
            // Other errors
            toast.error("Terjadi kesalahan yang tidak diketahui");
        }
    }
});

const submitStep2 = async () => {
    try {
        const promises = domisili.value.map((domisili) =>
            apiPost("/domisili", {
                status_tempat_tinggal: domisili.status_tempat_tinggal,
                penduduk_id: pendudukId.value,
                rt_id: domisili.rt_id,
                alamat_asal: domisili.alamat_asal,
                alamat_saat_ini: domisili.alamat_saat_ini,
            })
        );

        await Promise.all(promises);

        toast.success("Data Domisili berhasil disimpan");
        router.visit("/admin/penduduk");
    } catch (error) {
        useErrorHandler(error);
    }
};

watch(searchAyah, async (val) => {
    if (val.length < 2) {
        ayahOptions.value = [];
        return;
    }
    loadingAyah.value = true;
    try {
        const res = await apiGet(
            `/penduduk?search=${val}&jenis_kelamin=L&status_perkawinan=kawin&exclude_ayah=true`
        );
        ayahOptions.value = res.data.data.map((p) => ({
            value: p.id.toString(),
            label: p.nama_lengkap,
        }));
    } catch {
        ayahOptions.value = [];
    }
    loadingAyah.value = false;
});
watch(searchAyah, (val) => {
    if (values.ayah_id && val.length < 12) {
        setFieldValue("ayah_id", "");
    }
});
const selectAyah = (option) => {
    setFieldValue("ayah_id", option.value);
    searchAyah.value = option.label;
    ayahOptions.value = [];
};

watch(searchIbu, async (val) => {
    if (val.length < 2) {
        ibuOptions.value = [];
        return;
    }
    loadingIbu.value = true;
    try {
        const res = await apiGet(
            `/penduduk?search=${val}&jenis_kelamin=P&status_perkawinan=kawin&exclude_ibu=true`
        );
        ibuOptions.value = res.data.data.map((p) => ({
            value: p.id.toString(),
            label: p.nama_lengkap,
        }));
    } catch {
        ibuOptions.value = [];
    }
    loadingIbu.value = false;
});
watch(searchIbu, (val) => {
    if (values.ibu_id && val.length < 12) {
        setFieldValue("ibu_id", "");
    }
});
const selectIbu = (option) => {
    setFieldValue("ibu_id", option.value);
    searchIbu.value = option.label;
    ibuOptions.value = [];
};

onMounted(async () => {
    try {
        const [pekerjaanRes, pendidikanRes, ayahRes, ibuRes, rtRes] =
            await Promise.all([
                apiGet("/pekerjaan"),
                apiGet("/pendidikan"),
                apiGet("/penduduk", {
                    jenis_kelamin: "L",
                    status_perkawinan: "kawin",
                    exclude_ayah: true,
                }),
                apiGet("/penduduk", {
                    jenis_kelamin: "P",
                    status_perkawinan: "kawin",
                    exclude_ibu: true,
                }),
                apiGet("/rt"),
            ]);

        const pekerjaanOptions = pekerjaanRes.data.data.map((item) => ({
            value: item.id.toString(),
            label: item.nama_pekerjaan,
        }));

        const pendidikanOptions = pendidikanRes.data.data.map((item) => ({
            value: item.id.toString(),
            label: item.jenjang,
        }));

        // const ayahOptions = ayahRes.data.data.map((item) => ({
        //     value: item.id.toString(),
        //     label: item.nama_lengkap,
        // }));

        // const ibuOptions = ibuRes.data.data.map((item) => ({
        //     value: item.id.toString(),
        //     label: item.nama_lengkap,
        // }));

        const rtOptions = rtRes.data.data.map((item) => ({
            value: item.id.toString(),
            label: item.nomor_rt,
        }));

        fields.value = [
            ...getFields(pekerjaanOptions, pendidikanOptions),
            // {
            //     name: "ayah_id",
            //     label: "Nama Ayah",
            //     type: "select",
            //     options: ayahOptions,
            //     placeholder: "Pilih Ayah",
            // },
            // {
            //     name: "ibu_id",
            //     label: "Nama Ibu",
            //     type: "select",
            //     options: ibuOptions,
            //     placeholder: "Pilih Ibu",
            // },
        ];

        fieldsDomisili.value = getFieldDomisili(rtOptions);
    } catch (error) {
        useErrorHandler(error);
    }
});
</script>

<template>
    <Head title="Tambah Penduduk" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Tambah Data Penduduk</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/admin/dashboard' },
                { label: 'Data Penduduk', href: '/admin/penduduk' },
                { label: 'Tambah Data Penduduk' },
            ]"
        />
    </div>

    <!-- Step Indicator -->
    <div class="flex items-center justify-center my-6">
        <div class="flex items-center space-x-4">
            <div class="flex items-center">
                <div
                    :class="[
                        'w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium',
                        currentStep >= 1
                            ? 'bg-primary text-white'
                            : 'bg-gray-200 text-gray-600',
                    ]"
                >
                    1
                </div>
                <span class="ml-2 text-sm font-medium">Data Penduduk</span>
            </div>
            <div class="w-16 h-0.5 bg-gray-200"></div>
            <div class="flex items-center">
                <div
                    :class="[
                        'w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium',
                        currentStep >= 2
                            ? 'bg-primary text-white'
                            : 'bg-gray-200 text-gray-600',
                    ]"
                >
                    2
                </div>
                <span class="ml-2 text-sm font-medium">Domisili</span>
            </div>
        </div>
    </div>

    <div v-if="currentStep === 1" class="shadow-lg p-8 my-4 rounded-lg">
        <form
            @submit.prevent="nextStep"
            class="space-y-6 grid grid-cols-2 gap-x-8"
        >
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
                        <Datepicker
                            v-else-if="field.type === 'datepicker'"
                            locale="id"
                            :enable-time-picker="false"
                            :format="'dd MMMM yyyy'"
                            v-bind="componentField"
                        />
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>

            <FormField name="ayah_id" v-slot="{ errorMessage }">
                <FormItem>
                    <FormLabel>Nama Ayah</FormLabel>
                    <FormControl>
                        <div class="autocomplete-wrapper" style="position: relative">
                            <Input
                                v-model="searchAyah"
                                placeholder="Ketik nama ayah"
                                autocomplete="off"
                            />
                            <div
                                v-if="searchAyah.length >= 2 && !values.ayah_id"
                                class="autocomplete-dropdown border rounded bg-white shadow mt-1 max-h-40 overflow-auto z-50"
                            >
                                <div v-if="loadingAyah" class="p-2 text-gray-500 text-center">
                                    Memuat data...
                                </div>
                                <div
                                    v-else-if="ayahOptions.length"
                                    v-for="option in ayahOptions"
                                    :key="option.value"
                                    class="p-2 hover:bg-blue-100 cursor-pointer"
                                    @click="selectAyah(option)"
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

            <FormField name="ibu_id" v-slot="{ errorMessage }">
                <FormItem>
                    <FormLabel>Nama Ibu</FormLabel>
                    <FormControl>
                        <div class="autocomplete-wrapper" style="position: relative">
                            <Input
                                v-model="searchIbu"
                                placeholder="Ketik nama ibu"
                                autocomplete="off"
                            />
                            <div
                                v-if="searchIbu.length >= 2 && !values.ibu_id"
                                class="autocomplete-dropdown border rounded bg-white shadow mt-1 max-h-40 overflow-auto z-50"
                            >
                                <div v-if="loadingIbu" class="p-2 text-gray-500 text-center">
                                    Memuat data...
                                </div>
                                <div
                                    v-else-if="ibuOptions.length"
                                    v-for="option in ibuOptions"
                                    :key="option.value"
                                    class="p-2 hover:bg-blue-100 cursor-pointer"
                                    @click="selectIbu(option)"
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
                        @click="router.visit('/admin/penduduk')"
                        type="button"
                        variant="secondary"
                        >Batal</Button
                    >
                    <Button type="submit" :disabled="!isStep1Valid"
                        >Selanjutnya</Button
                    >
                </div>
            </div>
        </form>
    </div>
    <div v-if="currentStep === 2" class="shadow-lg p-8 my-4 rounded-lg">
        <!-- Loop all fields except foto -->
        <div class="space-y-6 grid grid-cols-2 gap-x-8">
            <FormField
                v-for="field in fieldsDomisili"
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
        </div>

        <div class="flex col-span-2 justify-between items-center">
            <div>
                <p>Peringatan</p>
            </div>
            <div class="flex gap-2 items-center">
                <Button type="submit" @click="submitStep2">Simpan</Button>
            </div>
        </div>
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

.autocomplete-dropdown {
    position: absolute;
    left: 0;
    right: 0;
    z-index: 50;
}
.autocomplete-wrapper {
    position: relative;
}
</style>
