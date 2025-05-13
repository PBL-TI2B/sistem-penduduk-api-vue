<script setup>
import IslamIcon from "@/images/islam.svg";
import KristenIcon from "@/images/kristen.svg";
import KatolikIcon from "@/images/katolik.svg";
import HinduIcon from "@/images/hindu.svg";
import BuddhaIcon from "@/images/budha.svg";
import KonghucuIcon from "@/images/konghucu.svg";

// Kepercayaan
const kepercayaan = [
    { icon: IslamIcon, nama: "Islam", jumlah: 1150 },
    { icon: KristenIcon, nama: "Kristen", jumlah: 500 },
    { icon: KatolikIcon, nama: "Katolik", jumlah: 200 },
    { icon: HinduIcon, nama: "Hindu", jumlah: 5 },
    { icon: BuddhaIcon, nama: "Buddha", jumlah: 0 },
    { icon: KonghucuIcon, nama: "Konghucu", jumlah: 10 },
];
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
