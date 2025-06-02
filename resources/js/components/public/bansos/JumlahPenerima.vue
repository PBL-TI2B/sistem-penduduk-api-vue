<script setup>
import { onMounted } from "vue";
import { useBantuan } from "@/composables/useBantuan";

const { items, fetchBantuan } = useBantuan();

onMounted(async () => {
    await fetchBantuan();
});
</script>

<template>
    <!-- Judul Section -->
    <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-8">
        Jumlah Penerima Bansos
    </h2>

    <!-- Grid Cards -->
    <div class="grid grid-cols-2 md:grid-cols-2 gap-4 mb-8">
        <div
            v-for="dataBantuanItem in items"
            :key="dataBantuanItem.id"
            class="bg-white rounded-[20px] px-6 py-4 flex items-center space-x-4 shadow-sm hover:drop-shadow-lg"
        >
            <div class="text-center">
                <!-- <p class="text-2xl font-bold text-[#233D34] leading-tight">
                    67
                </p> -->
                <p class="text-2xl font-bold text-[#233D34] leading-tight">
                    {{ dataBantuanItem.penerima_bantuan_count }}
                </p>
                <p class="text-sm md:text-lg text-black -mt-1">Penduduk</p>
            </div>
            <p class="text-sm md:text-lg text-black">
                mendapatkan bantuan <br />
                <!-- <span class="font-bold">BPJS PBI Ketenagakerjaan</span> -->
                <span class="font-bold">
                    {{ dataBantuanItem.nama_bantuan }}
                </span>
            </p>
        </div>
    </div>
</template>
