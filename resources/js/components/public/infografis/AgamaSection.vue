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
        const res = await axios.get(
            "http://127.0.0.1:8000/api/v1/statistik/agama"
        );
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
    <section>
        <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-10">
            Berdasarkan Kepercayaan
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-center">
            <div
                v-for="(item, index) in kepercayaan"
                :key="index"
                class="bg-white shadow-sm hover:drop-shadow-lg p-4 rounded-[20px] flex flex-col items-center justify-center"
            >
                <img :src="item.icon" alt="" class="w-12 h-12 mb-2" />
                <p class="text-[#233D34] font-medium">
                    {{ item.nama }}
                </p>
                <p
                    :class="{
                        'text-[#E5A025] font-semibold': item.jumlah > 0,
                        'text-orange-400': item.jumlah === 0,
                    }"
                >
                    {{ item.jumlah.toLocaleString("id-ID") }}
                </p>
            </div>
        </div>
    </section>
</template>
