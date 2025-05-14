<script setup>
import { onMounted, onUnmounted, ref } from "vue";
import { Head } from "@inertiajs/vue3";
import PublicLayout from "@/Layouts/PublicLayout.vue";

import PendudukSection from "@/components/public/infografis/PendudukSection.vue";
import UmurSection from "@/components/public/infografis/UmurSection.vue";
import PendidikanSection from "@/components/public/infografis/PendidikanSection.vue";
import PekerjaanSection from "@/components/public/infografis/PekerjaanSection.vue";
import AgamaSection from "@/components/public/infografis/AgamaSection.vue";
import KelahiranKematianSection from "@/components/public/infografis/KelahiranKematianSection.vue";

import JumlahPenerima from "@/components/public/bansos/JumlahPenerima.vue";
import CekBansos from "@/components/public/bansos/CekBansos.vue";

defineOptions({
    layout: PublicLayout,
});

const activeTab = ref("penduduk"); // nilai default tab
</script>

<template>
    <Head title=" - Infografis" />

    <div class="bg-gray-50 min-h-screen px-6 py-8 pt-15">
        <div class="flex flex-col max-w-6xl mx-auto py-8">
            <!-- Judul & Navigasi -->
            <div
                class="flex justify-between items-center flex-wrap gap-4 mt-6 mb-8"
            >
                <h1 class="text-3xl font-bold text-[#E5A025]">
                    INFOGRAFIS<br class="sm:hidden" />
                    DESA JABUNG
                </h1>

                <!-- Tab Navigasi -->
                <div class="flex space-x-6">
                    <button
                        @click="activeTab = 'penduduk'"
                        :class="[
                            'flex items-center space-x-2 pb-1 transition font-medium',
                            activeTab === 'penduduk'
                                ? 'text-gray-800 border-b-2 border-[#E5A025]'
                                : 'text-gray-500 hover:text-gray-800 hover:border-b-2 hover:border-[#E5A025]',
                        ]"
                    >
                        <span>Penduduk</span>
                    </button>
                    <button
                        @click="activeTab = 'bansos'"
                        :class="[
                            'flex items-center space-x-2 pb-1 transition font-medium',
                            activeTab === 'bansos'
                                ? 'text-gray-800 border-b-2 border-[#E5A025]'
                                : 'text-gray-500 hover:text-gray-800 hover:border-b-2 hover:border-[#E5A025]',
                        ]"
                    >
                        <span>Bansos</span>
                    </button>
                </div>
            </div>

            <!-- Deskripsi Umum -->
            <div v-if="activeTab === 'penduduk'" class="mb-6">
                <h2 class="text-[#2FB586] font-bold text-2xl mb-2">
                    DEMOGRAFI PENDUDUK
                </h2>
                <p class="text-sm md:text-lg text-gray-600">
                    Memberikan informasi lengkap mengenai karakteristik
                    demografi penduduk suatu wilayah. Mulai dari jumlah
                    penduduk, usia, jenis kelamin, tingkat pendidikan,
                    pekerjaan, agama, dan aspek penting lainnya yang
                    menggambarkan komposisi populasi secara rinci.
                </p>
            </div>

            <div v-else-if="activeTab === 'bansos'" class="mb-6">
                <h2 class="text-[#2FB586] font-bold text-2xl mb-2">
                    BANTUAN SOSIAL
                </h2>
                <p class="text-sm md:text-lg text-gray-600">
                    Memberikan informasi mengenai jumlah serta jenis bantuan
                    sosial yang diterima oleh masyarakat. Disini juga dapat
                    dilakukan pencarian pemenerima bantuan sosial dengan
                    memasukkan NIK pada kolom pencarian bantuan sosial.
                </p>
            </div>

            <!-- Component Section berdasarkan Tab -->
            <div v-show="activeTab === 'penduduk'">
                <PendudukSection />
                <UmurSection />
                <PendidikanSection />
                <PekerjaanSection />
                <AgamaSection />
                <KelahiranKematianSection />
            </div>

            <div v-show="activeTab === 'bansos'">
                <JumlahPenerima />
                <CekBansos />
                <!-- Bisa tambahkan komponen input & tabel seperti sebelumnya -->
            </div>
        </div>
    </div>
</template>
