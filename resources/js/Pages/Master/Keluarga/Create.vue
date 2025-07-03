<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form";
import { getFields } from "./utils/fields";
import { onMounted, ref, computed, watch } from "vue";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Trash2, Plus, Upload, Download, X } from "lucide-vue-next";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { apiGet, apiPost } from "@/utils/api";
import { router } from "@inertiajs/vue3";
import { createFormSchema } from "./utils/form-schema";
import { useForm } from "vee-validate";
import { Input } from "@/components/ui/input";
import { toast } from "vue-sonner";
import { Head } from "@inertiajs/vue3";

const currentStep = ref(1);
const fields = ref([]);
const anggotaKeluarga = ref([]);
const statusKeluargaOptions = ref([]);
const kartuKeluargaId = ref(null);
const isInputMassal = ref(false);
const massalData = ref("");

const { handleSubmit, values } = useForm({
    validationSchema: createFormSchema(),
});

const isStep1Valid = computed(() => {
    const requiredFields = [
        "nomor_kk",
        "rt_id",
        "kelurahan",
        "kecamatan",
        "kode_pos",
        "kabupaten",
        "provinsi",
    ];
    return requiredFields.every(
        (field) => values[field] && values[field].toString().trim() !== ""
    );
});

const nextStep = async () => {
    if (currentStep.value === 1) {
        await submitStep1();
    } else if (currentStep.value === 2) {
        await submitStep2();
    }
};

const submitStep1 = handleSubmit(async (formValues) => {
    try {
        const checkUrl = `/kartu-keluarga/check-kk?nomor_kk=${formValues.nomor_kk}`;
        const checkResponse = await apiGet(checkUrl);
        if (!checkResponse.isAvailable) {
            toast.error("Nomor KK sudah terdaftar");
            return;
        }

        const formData = new FormData();
        for (const [key, value] of Object.entries(formValues)) {
            formData.append(key, value ?? "");
        }

        const response = await apiPost("/kartu-keluarga", formData);
        kartuKeluargaId.value = response.data.id;

        toast.success("Data Kartu Keluarga berhasil disimpan");
        currentStep.value = 2;
    } catch (error) {
        useErrorHandler(error);
    }
});

const submitStep2 = async () => {
    try {
        for (const anggota of anggotaKeluarga.value) {
            if (!anggota.penduduk_id || !anggota.status_keluarga_id) {
                toast.error("Harap lengkapi semua data anggota keluarga.");
                console.log(anggota);
                return;
            }
        }

        const promises = anggotaKeluarga.value.map((anggota) =>
            apiPost("/anggota-keluarga", {
                kk_id: kartuKeluargaId.value,
                penduduk_id: anggota.penduduk_id,
                status_keluarga_id: anggota.status_keluarga_id,
            })
        );

        await Promise.all(promises);

        toast.success("Data Anggota Keluarga berhasil disimpan");
        router.visit("/admin/keluarga");
    } catch (error) {
        useErrorHandler(error);
    }
};

watch(
    anggotaKeluarga,
    (newAnggotaList) => {
        newAnggotaList.forEach((anggota) => {
            watch(
                () => anggota.penduduk_id,
                (val) => {
                    if (!val) {
                        anggota.nama_penduduk = null;
                        return;
                    }
                    // Cari label dari options
                    const found = anggota.pendudukOptions.find(
                        (opt) => opt.value === val
                    );
                    anggota.nama_penduduk = found ? found.label : null;
                }
            );
        });
    },
    { deep: true }
);

watch(
    anggotaKeluarga,
    (newAnggotaList) => {
        newAnggotaList.forEach((anggota) => {
            watch(
                () => anggota.searchPenduduk,
                (val) => {
                    clearTimeout(anggota.pendudukDebounceTimer);

                    if (!val || val.length < 2) {
                        anggota.pendudukOptions = [];
                        return;
                    }

                    if (anggota.penduduk_id && anggota.nama_penduduk === val)
                        return;

                    anggota.loadingPenduduk = true;
                    anggota.pendudukDebounceTimer = setTimeout(async () => {
                        try {
                            const res = await apiGet(
                                `/penduduk?search=${val}&tanpa_kk=true`
                            );
                            anggota.pendudukOptions = res.data.data.map(
                                (p) => ({
                                    value: p.id.toString(),
                                    label: `${p.nama_lengkap} (${p.nik})`,
                                })
                            );
                        } catch {
                            anggota.pendudukOptions = [];
                        } finally {
                            anggota.loadingPenduduk = false;
                        }
                    }, 500);
                }
            );
        });
    },
    { deep: true }
);

const selectPenduduk = (anggota, option) => {
    anggota.penduduk_id = option.value;
    anggota.nama_penduduk = option.label;
    anggota.searchPenduduk = option.label;
    anggota.isPendudukSelectOpen = false;
};

const clearPilihanPenduduk = (anggota) => {
    anggota.penduduk_id = null;
    anggota.nama_penduduk = null;
    anggota.searchPenduduk = "";
    anggota.pendudukOptions = [];
};

const addAnggotaKeluarga = () => {
    anggotaKeluarga.value.push({
        id: Date.now(),
        status_keluarga_id: "",
        penduduk_id: null,
        nama_penduduk: null,
        searchPenduduk: "",
        pendudukOptions: [],
        loadingPenduduk: false,
        isPendudukSelectOpen: false,
        pendudukDebounceTimer: null,
    });
};

const removeAnggotaKeluarga = (index) => {
    anggotaKeluarga.value.splice(index, 1);
};

const toggleInputMassal = () => {
    isInputMassal.value = !isInputMassal.value;
    if (isInputMassal.value) {
        massalData.value = "";
    }
};

const prosesInputMassal = () => {
    try {
        const lines = massalData.value
            .split("\n")
            .filter((line) => line.trim());
        const newAnggota = [];

        lines.forEach((line) => {
            const parts = line.split(",").map((part) => part.trim());
            if (parts.length >= 2) {
                newAnggota.push({
                    id: Date.now() + newAnggota.length,
                    penduduk_id: parts[0],
                    status_keluarga_id: parts[1],
                    nama_penduduk: null,
                    searchPenduduk: "",
                    pendudukOptions: [],
                    loadingPenduduk: false,
                    isPendudukSelectOpen: false,
                    pendudukDebounceTimer: null,
                });
            }
        });

        if (newAnggota.length > 0) {
            anggotaKeluarga.value = [...anggotaKeluarga.value, ...newAnggota];
            massalData.value = "";
            isInputMassal.value = false;
            toast.success(
                `Berhasil menambahkan ${newAnggota.length} anggota keluarga`
            );
        } else {
            toast.error("Format data tidak valid");
        }
    } catch (error) {
        toast.error("Gagal memproses data massal");
    }
};

const downloadTemplate = () => {
    const template = `# Template Input Massal Anggota Keluarga
# Format: penduduk_id,status_keluarga_id
# Contoh:
# 1,1
# 2,2
# 3,3

# Catatan:
# - Setiap baris adalah satu anggota keluarga
# - Gunakan koma (,) sebagai pemisah
# - Hapus baris yang dimulai dengan # sebelum input`;

    const blob = new Blob([template], { type: "text/plain" });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "template_anggota_keluarga.txt";
    a.click();
    window.URL.revokeObjectURL(url);
};

const getStatusKeluargaName = (statusId) => {
    const status = statusKeluargaOptions.value.find(
        (s) => s.value === statusId
    );
    return status ? status.label : "Tidak ditemukan";
};

onMounted(async () => {
    try {
        const [resRT, resStatus] = await Promise.all([
            apiGet("/rt"),
            apiGet("/status-keluarga"),
        ]);

        const rtOptions = resRT.data.data.map((item) => ({
            value: item.id.toString(),
            label: item.nomor_rt,
        }));
        fields.value = [...getFields(rtOptions)];

        statusKeluargaOptions.value = resStatus.data.data.map((item) => ({
            value: item.id.toString(),
            label: item.status_keluarga,
        }));

        addAnggotaKeluarga();
    } catch (error) {
        useErrorHandler(error);
    }
});
</script>

<template>
    <Head title=" | Tambah Kartu Keluarga" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Tambah Data Kartu Keluarga</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/admin/dashboard' },
                { label: 'Data Kartu Keluarga', href: '/admin/keluarga' },
                { label: 'Tambah Data Kartu Keluarga' },
            ]"
        />
    </div>

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
                <span class="ml-2 text-sm font-medium"
                    >Data Kartu Keluarga</span
                >
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
                <span class="ml-2 text-sm font-medium">Anggota Keluarga</span>
            </div>
        </div>
    </div>

    <div v-if="currentStep === 1" class="shadow-lg p-8 my-4 rounded-lg">
        <h2 class="text-xl font-semibold mb-6">Step 1: Data Kartu Keluarga</h2>
        <form
            @submit.prevent="nextStep"
            class="space-y-6 grid grid-cols-2 gap-x-8"
        >
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

            <div class="flex col-span-2 justify-between items-center">
                <div>
                    <p class="text-sm text-gray-600">Step 1 dari 2</p>
                </div>
                <div class="flex gap-2 items-center">
                    <Button
                        @click="router.visit('/admin/keluarga')"
                        type="button"
                        variant="secondary"
                    >
                        Batal
                    </Button>
                    <Button type="submit" :disabled="!isStep1Valid">
                        Selanjutnya
                    </Button>
                </div>
            </div>
        </form>
    </div>

    <div v-if="currentStep === 2" class="shadow-lg p-8 my-4 rounded-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Step 2: Anggota Keluarga</h2>
            <div class="flex gap-2">
                <Button
                    @click="downloadTemplate"
                    variant="outline"
                    size="sm"
                    class="flex items-center gap-2"
                >
                    <Download class="w-4 h-4" />
                    Template
                </Button>
                <Button
                    @click="toggleInputMassal"
                    variant="outline"
                    size="sm"
                    class="flex items-center gap-2"
                >
                    <Upload class="w-4 h-4" />
                    Input Massal
                </Button>
                <Button
                    @click="addAnggotaKeluarga"
                    size="sm"
                    class="flex items-center gap-2"
                >
                    <Plus class="w-4 h-4" />
                    Tambah Anggota
                </Button>
            </div>
        </div>

        <Card v-if="isInputMassal" class="mb-6">
            <CardHeader>
                <CardTitle class="text-lg"
                    >Input Massal Anggota Keluarga</CardTitle
                >
            </CardHeader>
            <CardContent>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Format: penduduk_id,status_keluarga_id (satu per
                            baris)
                        </label>
                        <textarea
                            v-model="massalData"
                            placeholder="Contoh:&#10;1,1&#10;2,2&#10;3,3"
                            class="w-full h-32 p-3 border border-gray-300 rounded-md"
                        ></textarea>
                    </div>
                    <div class="flex gap-2">
                        <Button @click="prosesInputMassal" size="sm">
                            Proses Data
                        </Button>
                        <Button
                            @click="toggleInputMassal"
                            variant="outline"
                            size="sm"
                        >
                            Batal
                        </Button>
                    </div>
                </div>
            </CardContent>
        </Card>

        <div class="space-y-6">
            <div
                v-for="(anggota, index) in anggotaKeluarga"
                :key="anggota.id"
                class="border border-gray-200 rounded-lg p-4"
            >
                <div class="flex justify-between items-start mb-4">
                    <h3 class="font-medium">
                        Anggota Keluarga {{ index + 1 }}
                    </h3>
                    <Button
                        @click="removeAnggotaKeluarga(index)"
                        variant="destructive"
                        size="sm"
                        class="flex items-center gap-1"
                    >
                        <Trash2 class="w-4 h-4" />
                        Hapus
                    </Button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2"
                            >Penduduk</label
                        >
                        <div
                            v-if="anggota.penduduk_id"
                            class="flex items-center gap-2 p-2 border rounded-md bg-muted"
                        >
                            <span class="flex-1 text-sm">{{
                                anggota.nama_penduduk
                            }}</span>
                            <Button
                                @click="clearPilihanPenduduk(anggota)"
                                variant="ghost"
                                size="sm"
                                class="p-1 h-auto"
                            >
                                <X class="w-4 h-4" />
                            </Button>
                        </div>

                        <Select
                            v-else
                            v-model="anggota.penduduk_id"
                            v-model:open="anggota.isPendudukSelectOpen"
                        >
                            <SelectTrigger class="w-full">
                                <SelectValue
                                    placeholder="Ketik nama penduduk atau NIK..."
                                />
                            </SelectTrigger>
                            <SelectContent>
                                <div class="p-2">
                                    <Input
                                        v-model="anggota.searchPenduduk"
                                        placeholder="Ketik untuk mencari..."
                                        class="mb-2"
                                    />
                                </div>
                                <div
                                    v-if="anggota.loadingPenduduk"
                                    class="p-2 text-center text-sm text-gray-500"
                                >
                                    Mencari...
                                </div>
                                <div
                                    v-else-if="
                                        anggota.pendudukOptions.length === 0 &&
                                        anggota.searchPenduduk.length >= 2
                                    "
                                    class="p-2 text-center text-sm text-gray-500"
                                >
                                    Data tidak ditemukan
                                </div>
                                <SelectItem
                                    v-else
                                    v-for="option in anggota.pendudukOptions"
                                    :key="option.value"
                                    :value="option.value"
                                    @click.prevent="
                                        selectPenduduk(anggota, option)
                                    "
                                >
                                    <span>{{ option.label }}</span>
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2"
                            >Status dalam Keluarga</label
                        >
                        <Select v-model="anggota.status_keluarga_id">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Pilih Status..." />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="option in statusKeluargaOptions"
                                    :key="option.value"
                                    :value="option.value"
                                >
                                    {{ option.label }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                </div>

                <div
                    v-if="anggota.penduduk_id || anggota.status_keluarga_id"
                    class="mt-3 p-3 bg-gray-50 rounded"
                >
                    <div class="flex flex-wrap gap-2">
                        <Badge v-if="anggota.penduduk_id" variant="secondary">
                            {{ anggota.nama_penduduk }}
                        </Badge>
                        <Badge
                            v-if="anggota.status_keluarga_id"
                            variant="outline"
                        >
                            {{
                                getStatusKeluargaName(
                                    anggota.status_keluarga_id
                                )
                            }}
                        </Badge>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center mt-8">
            <div>
                <p class="text-sm text-gray-600">Step 2 dari 2</p>
                <p class="text-sm text-gray-500">
                    {{ anggotaKeluarga.length }} anggota keluarga
                </p>
            </div>
            <div class="flex gap-2 items-center">
                <Button
                    @click="currentStep = 1"
                    type="button"
                    variant="secondary"
                >
                    Kembali
                </Button>
                <Button
                    @click="submitStep2"
                    :disabled="anggotaKeluarga.length === 0"
                >
                    Simpan Semua
                </Button>
            </div>
        </div>
    </div>
</template>
