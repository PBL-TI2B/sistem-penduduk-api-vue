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
    <!-- <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-8">
        Jumlah Penduduk dan Kepala Keluarga
    </h2> -->
    <section class="bg-gray shadow-md rounded-xl py-12 px-2 lg:p-6">
        <div
            class="flex items-center gap-2 bg-[#e7fcee] text-green-700 font-semibold px-4 py-2 rounded-full w-fit mb-4"
        >
            <div class="w-1 h-6 bg-green-500 rounded"></div>
            <div
                class="flex items-center gap-2 md:text-lg font-bold text-[#233D34]"
            >
                <span>Jumlah Penduduk dan Kepala Keluarga</span>
            </div>
        </div>

        <div
            :class="{
                'relative grid lg:grid-cols-4  gap-4 text-white text-center':
                    isActive('/infografis') || isActive('/admin/dashboard'),
            }"
        >
            <div
                class="bg-white p-4 rounded-md flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
            >
                <img
                    src="@/images/ttlpenduduk.png"
                    alt="Total Penduduk"
                    class="w-12 h-12"
                />
                <div class="text-start">
                    <p class="text-sm md:text-lg text-[#40798C]">
                        TOTAL PENDUDUK
                    </p>
                    <p class="text-xl font-bold text-[#40798C]">
                        {{ statistik.total_penduduk }} Jiwa
                    </p>
                </div>
            </div>
            <div
                class="bg-white p-4 rounded-md flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
            >
                <img
                    src="@/images/kepalakeluarga.png"
                    alt="Kepala Keluarga"
                    class="w-12 h-12"
                />
                <div class="text-start">
                    <p class="text-sm md:text-lg text-[#70A9A1]">
                        KEPALA KELUARGA
                    </p>
                    <p class="text-xl font-bold text-[#70A9A1]">
                        {{ statistik.jumlah_kepala_keluarga }} Jiwa
                    </p>
                </div>
            </div>
            <div
                class="bg-white p-4 rounded-md flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
            >
                <img
                    src="@/images/laki.png"
                    alt="Laki-Laki"
                    class="w-12 h-12"
                />
                <div class="text-start">
                    <p class="text-sm md:text-lg text-[#CD8B76]">LAKI-LAKI</p>
                    <p class="text-xl font-bold text-[#CD8B76]">
                        {{ statistik.jumlah_laki_laki }} Jiwa
                    </p>
                </div>
            </div>
            <div
                class="bg-white p-4 rounded-md flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
            >
                <img
                    src="@/images/perempuan.png"
                    alt="Perempuan"
                    class="w-12 h-12"
                />
                <div class="text-start">
                    <p class="text-sm md:text-lg text-[#734B5E]">PEREMPUAN</p>
                    <p class="text-xl font-bold text-[#734B5E]">
                        {{ statistik.jumlah_perempuan }} Jiwa
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
