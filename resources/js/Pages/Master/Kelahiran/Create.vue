<!-- src/pages/Kelahiran/Add.vue -->
<script setup>
import { ref } from "vue";
import { toast } from "vue-sonner";
import { Head } from "@inertiajs/vue3";

import { apiPost } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { usePenduduk } from "@/composables/usePenduduk";
import { useKelahiran } from "@/composables/useKelahiran";

// Impor komponen formulir anak
import PendudukForm from "./components/PendudukForm.vue";
import KelahiranForm from "./components/KelahiranForm.vue";

import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";

// === STATE ===
const step = ref(1); // Mulai dari langkah 1 (formulir penduduk)
const fotoFile = ref(null);
const fotoPreview = ref(null);
const pendudukId = ref(null); // Menyimpan ID/UUID penduduk yang berhasil dibuat
const isLoading = ref(false);

const { createPenduduk } = usePenduduk();
const { createData: createKelahiran } = useKelahiran();

// === Handler untuk Form Penduduk ===
const handlePendudukSubmit = async (values) => {
    try {
        isLoading.value = true;
        const formData = new FormData();
        for (const [key, value] of Object.entries(values)) {
            if (value !== null && value !== undefined) {
                formData.append(key, value);
            }
        }
        if (fotoFile.value) formData.append("foto", fotoFile.value);

        const res = await apiPost("/penduduk", formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });

        pendudukId.value = res.data.id;
        toast.success("Data Penduduk Berhasil Ditambahkan");
        step.value = 2; // Lanjut ke langkah 2
    } catch (error) {
        useErrorHandler(error);
    } finally {
        isLoading.value = false;
    }
};

// === Handler untuk Form Kelahiran ===
const handleKelahiranSubmit = async (values) => {
    try {
        isLoading.value = true;
        // pendudukId sudah dijamin ada karena ini adalah langkah kedua
        const payload = { ...values, penduduk_id: pendudukId.value };
        await createKelahiran(payload);
    } catch (error) {
        useErrorHandler(error);
    } finally {
        isLoading.value = false;
    }
};

// Fungsi untuk kembali ke langkah sebelumnya
const handleGoBack = () => {
    step.value = 1;
};
</script>

<template>
    <Head title="Tambah Kelahiran Penduduk" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Tambah Kelahiran Penduduk</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/admin/dashboard' },
                { label: 'Data Kelahiran', href: '/admin/kelahiran' },
                { label: 'Tambah Data Kelahiran' },
            ]"
        />
    </div>

    <div class="mt-4">
        <div class="flex items-center justify-center my-6">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <div
                        :class="[
                            'w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium',
                            step >= 1
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
                            step >= 2
                                ? 'bg-primary text-white'
                                : 'bg-gray-200 text-gray-600',
                        ]"
                    >
                        2
                    </div>
                    <span class="ml-2 text-sm font-medium">Data Kelahiran</span>
                </div>
            </div>
        </div>
        <!-- Render PendudukForm jika step === 1 -->
        <PendudukForm
            v-if="step === 1"
            :isLoading="isLoading"
            v-model:fotoFile="fotoFile"
            v-model:fotoPreview="fotoPreview"
            @submit="handlePendudukSubmit"
        />

        <!-- Render KelahiranForm jika step === 2 -->
        <KelahiranForm
            v-if="step === 2"
            :isLoading="isLoading"
            :pendudukId="pendudukId"
            @submit="handleKelahiranSubmit"
            @back="handleGoBack"
        />
    </div>
</template>
