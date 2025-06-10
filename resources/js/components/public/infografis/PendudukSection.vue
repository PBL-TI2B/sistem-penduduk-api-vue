<script setup>
import { ref, onMounted, watch } from "vue";
import { router, usePage } from "@inertiajs/vue3";
// import axios from "axios";
import { useStatistik } from "@/composables/useStatistik";

const { statistikItems, fetchStatistikByType } = useStatistik();

onMounted(async () => {
    await fetchStatistikByType("demografi");
    statistik.value = statistikItems.value;
});

// State untuk menyimpan data dari API
const statistik = ref({
    total_penduduk: 0,
    jumlah_kepala_keluarga: 0,
    jumlah_laki_laki: 0,
    jumlah_perempuan: 0,
});

const page = usePage();
const isActive = (path) => page.url === path;
console.log(page.url);
</script>

<template>
    <!-- Demografi Penduduk -->
    <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-8">
        Jumlah Penduduk dan Kepala Keluarga
    </h2>
    <div
        :class="{
            'relative grid gap-4 text-white text-center':
                isActive('/infografis') || isActive('/admin/dashboard'),
            'grid-cols-2 md:grid-cols-2': isActive('/infografis'),
            'grid-cols-4': isActive('/admin/dashboard'),
        }"
    >
        <div
            class="bg-[#40798C] p-4 rounded-[20px] flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
        >
            <img
                src="@/images/ttlpenduduk.png"
                alt="Total Penduduk"
                class="w-12 h-12"
            />
            <div class="text-start">
                <p class="text-sm md:text-lg">TOTAL PENDUDUK</p>
                <p class="text-xl font-bold">
                    {{ statistik.total_penduduk }} Jiwa
                </p>
            </div>
        </div>
        <div
            class="bg-[#70A9A1] p-4 rounded-[20px] flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
        >
            <img
                src="@/images/kepalakeluarga.png"
                alt="Kepala Keluarga"
                class="w-12 h-12"
            />
            <div class="text-start">
                <p class="text-sm md:text-lg">KEPALA KELUARGA</p>
                <p class="text-xl font-bold">
                    {{ statistik.jumlah_kepala_keluarga }} Jiwa
                </p>
            </div>
        </div>
        <div
            class="bg-[#CD8B76] p-4 rounded-[20px] flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
        >
            <img src="@/images/laki.png" alt="Laki-Laki" class="w-12 h-12" />
            <div class="text-start">
                <p class="text-sm md:text-lg">LAKI-LAKI</p>
                <p class="text-xl font-bold">
                    {{ statistik.jumlah_laki_laki }} Jiwa
                </p>
            </div>
        </div>
        <div
            class="bg-[#734B5E] p-4 rounded-[20px] flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
        >
            <img
                src="@/images/perempuan.png"
                alt="Perempuan"
                class="w-12 h-12"
            />
            <div class="text-start">
                <p class="text-sm md:text-lg">PEREMPUAN</p>
                <p class="text-xl font-bold">
                    {{ statistik.jumlah_perempuan }} Jiwa
                </p>
            </div>
        </div>
    </div>
</template>
