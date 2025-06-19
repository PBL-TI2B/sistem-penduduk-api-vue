<script setup>
import { ref } from "vue";
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

const activeTab = ref("penduduk");
</script>

<template>
    <Head title=" - Infografis" />

    <div class="bg-gray-50 min-h-screen px-6 md:px-48 py-8 pt-15">
        <div class="flex flex-col max-w-6xl mx-auto py-8">
            <!-- SVG Lengkung Atas -->
            <div class="absolute top-0 left-0 w-full z-0">
                <svg
                    class="w-full h-[1000px] md:h-[600px]"
                    viewBox="0 0 1440 200"
                    preserveAspectRatio="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <defs>
                        <linearGradient
                            id="grad1"
                            x1="50%"
                            y1="0%"
                            x2="50%"
                            y2="100%"
                        >
                            <stop
                                offset="20%"
                                style="
                                    stop-color: oklch(84.5% 0.143 164.978);
                                    stop-opacity: 1;
                                "
                            />
                            <stop
                                offset="80%"
                                style="
                                    stop-color: oklch(59.6% 0.145 163.225);
                                    stop-opacity: 1;
                                "
                            />
                        </linearGradient>
                    </defs>
                    <path
                        fill="url(#grad1)"
                        d="M0,100 C360,160 1080,80 1440,120 L1440,0 L0,0 Z"
                    />
                </svg>
            </div>

            <!-- Kontainer Konten Atas -->
            <div
                class="relative z-10 max-w-5xl mx-auto px-6 pt-15 mb-20 text-center text-white"
            >
                <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow">
                    INFOGRAFIS DESA JABUNG
                </h1>
                <h2 class="text-xl md:text-xl mb-4 mt-4 drop-shadow">
                    Informasi Penduduk dan Bantuan Sosial dalam bentuk Statistik
                    Visual
                </h2>
            </div>
            <div class="flex justify-center gap-4 mt-8 z-0">
                <button
                    @click="activeTab = 'penduduk'"
                    :class="[
                        'px-5 py-2 font-semibold rounded-full text-sm transition',
                        activeTab === 'penduduk'
                            ? 'bg-emerald-600 text-white'
                            : 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200',
                    ]"
                >
                    Penduduk
                </button>
                <button
                    @click="activeTab = 'bansos'"
                    :class="[
                        'px-5 py-2 font-semibold rounded-full text-sm transition',
                        activeTab === 'bansos'
                            ? 'bg-emerald-600 text-white'
                            : 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200',
                    ]"
                >
                    Bantuan Sosial
                </button>
            </div>
            <!-- Component Section berdasarkan Tab -->
            <div v-show="activeTab === 'penduduk'">
                <PendudukSection />
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <UmurSection />
                    <AgamaSection />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <PendidikanSection />
                    <PekerjaanSection />
                </div>
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
