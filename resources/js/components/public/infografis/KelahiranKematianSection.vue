<script setup>
import { onMounted, ref } from "vue";
import Chart from "chart.js/auto";
import axios from "axios";

const tahun = 2021;
const chartInstance = ref(null);

const getDataPerBulan = (data) => {
    const perBulan = Array(12).fill(0);
    data.forEach((item) => {
        const bulanIndex = item.bulan - 1; // 0-indexed
        perBulan[bulanIndex] = item.jumlah;
    });
    return perBulan;
};

onMounted(async () => {
    const ctx = document
        .getElementById("kelahiranKematianChart")
        ?.getContext("2d");
    if (!ctx) return;

    try {
        const [kematianRes, kelahiranRes] = await Promise.all([
            axios.get("/api/v1/statistik/kematian?tahun=2021"),
            axios.get("/api/v1/statistik/kelahiran?tahun=2021"),
        ]);

        const kematianData = getDataPerBulan(kematianRes.data.data);
        const kelahiranData = getDataPerBulan(kelahiranRes.data.data);

        if (chartInstance.value) {
            chartInstance.value.destroy(); // Hapus chart lama
        }

        chartInstance.value = new Chart(ctx, {
            type: "line",
            data: {
                labels: [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember",
                ],
                datasets: [
                    {
                        label: "Kelahiran",
                        data: kelahiranData,
                        borderColor: "#F59E0B",
                        backgroundColor: "#F59E0B",
                        fill: false,
                        tension: 0.3,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    },
                    {
                        label: "Kematian",
                        data: kematianData,
                        borderColor: "#14532D",
                        backgroundColor: "#14532D",
                        borderWidth: 3,
                        fill: false,
                        tension: 0.3,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: "bottom" },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0,
                    },
                },
            },
        });
    } catch (error) {
        console.error("Gagal mengambil data:", error);
    }
});
</script>
<template>
    <section class="bg-gray shadow-md rounded-xl p-6 hidden md:block">
        <div class="flex items-center justify-between mb-4 mt-10">
            <div
                class="flex items-center gap-2 bg-[#e7fcee] text-green-700 font-semibold px-4 py-2 rounded-full w-fit mb-4"
            >
                <div class="w-1 h-6 bg-green-500 rounded"></div>
                <div
                    class="flex items-center gap-2 md:text-lg font-bold text-[#233D34]"
                >
                    <span>Angka Kelahiran dan Kematian </span>
                </div>
            </div>
            <span class="text-sm md:text-lg text-gray-500">{{ tahun }}</span>
        </div>
        <div class="relative w-full overflow-x-auto">
            <canvas id="kelahiranKematianChart" class="w-full h-auto"></canvas>
        </div>
    </section>
</template>
