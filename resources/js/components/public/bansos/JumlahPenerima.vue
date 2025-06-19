<script setup>
import { onMounted } from "vue";
import { useBantuan } from "@/composables/useBantuan";

const { items, fetchBantuan } = useBantuan();

onMounted(async () => {
    await fetchBantuan();
});
</script>

<template>
    <section class="bg-gray shadow-md rounded-xl p-6">
        <!-- Judul Section -->
        <div
            class="flex items-center gap-2 bg-[#e7fcee] text-green-700 font-semibold px-4 py-2 rounded-full w-fit mb-4"
        >
            <div class="w-1 h-6 bg-green-500 rounded"></div>
            <div
                class="flex items-center gap-2 text-xl font-bold text-[#233D34]"
            >
                <span>Jumlah Penerima Bansos</span>
            </div>
        </div>

        <!-- Grid Cards -->
        <div class="grid grid-cols-2 md:grid-cols-2 gap-4 mb-2">
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
    </section>
</template>
