<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

import IslamIcon from "@/images/islam.svg";
import KristenIcon from "@/images/kristen.svg";
import KatolikIcon from "@/images/katolik.svg";
import HinduIcon from "@/images/hindu.svg";
import BuddhaIcon from "@/images/budha.svg";
import KonghucuIcon from "@/images/konghucu.svg";

// Peta agama ke ikon
const iconMap = {
    Islam: IslamIcon,
    Kristen: KristenIcon,
    Katolik: KatolikIcon,
    Hindu: HinduIcon,
    Buddha: BuddhaIcon,
    Khonghucu: KonghucuIcon,
};

const kepercayaan = ref([]); // data dinamis

onMounted(async () => {
    try {
        const res = await axios.get("/api/v1/statistik/agama");
        const apiData = res.data.data;

        kepercayaan.value = apiData.map((item) => ({
            icon: iconMap[item.agama] || "", // fallback kosong jika tidak ada icon
            nama: item.agama,
            jumlah: item.jumlah,
        }));
    } catch (error) {
        console.error("Gagal ambil data statistik agama:", error);
    }
});
</script>

<template>
    <!-- Agama -->
    <section class="bg-gray shadow-md rounded-xl p-6">
        <div
            class="flex items-center gap-2 bg-[#e7fcee] text-green-700 font-semibold px-4 py-2 rounded-full w-fit mb-4"
        >
            <div class="w-1 h-6 bg-green-500 rounded"></div>
            <div
                class="flex items-center gap-2 md:text-lg font-bold text-[#233D34]"
            >
                <span>Berdasarkan Kepercayaan</span>
            </div>
        </div>
        <div class="grid grid-cols-3 md:grid-cols-2 gap-2 md:gap-4 text-center">
            <div
                v-for="(item, index) in kepercayaan"
                :key="index"
                class="bg-white shadow-sm hover:drop-shadow-lg p-4 rounded-[20px] flex flex-col items-center justify-center"
            >
                <img :src="item.icon" alt="" class="w-12 h-12 mb-2" />
                <p class="text-[#233D34] font-medium text-xs md:text-base">
                    {{ item.nama }}
                </p>
                <p
                    :class="{
                        'bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-emerald-500 font-semibold':
                            item.jumlah > 0,
                        'text-orange-400': item.jumlah === 0,
                    }"
                >
                    {{ item.jumlah.toLocaleString("id-ID") }}
                </p>
            </div>
        </div>
    </section>
</template>
