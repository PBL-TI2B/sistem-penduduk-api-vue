<script setup>
import { ref, onMounted, nextTick } from "vue";
import Chart from "chart.js/auto";
import axios from "axios";

const pendidikanChart = ref(null);
let chartInstance = null;

onMounted(async () => {
    await nextTick();

    try {
        const response = await axios.get(
            "http://127.0.0.1:8000/api/v1/statistik/pendidikan"
        );
        const data = response.data.data;

        const labels = data.map((item) => item.pendidikan);
        const values = data.map((item) => item.jumlah);

        const ctx = pendidikanChart.value.getContext("2d");
        if (!ctx) return;

        if (chartInstance) {
            chartInstance.destroy();
        }

        chartInstance = new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Jumlah",
                        data: values,
                        backgroundColor: "rgba(75, 85, 99, 0.8)",
                        borderRadius: 4,
                        borderSkipped: false,
                        barThickness: 25, // 🎯 Ukuran bar
                        categoryPercentage: 0.1, // 🎯 Jarak antar bar
                    },
                ],
            },
            options: {
                indexAxis: "y",
                responsive: true,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                    },
                },
            },
        });
    } catch (error) {
        console.error("Gagal mengambil data statistik pendidikan:", error);
    }
});
</script>

<template>
    <section class="bg-gray shadow-md rounded-xl p-6">
        <div
            class="flex items-center gap-2 bg-green-50 text-green-700 font-semibold px-4 py-2 rounded-full w-fit mb-4"
        >
            <div class="w-1 h-6 bg-green-500 rounded"></div>
            <div
                class="flex items-center gap-2 text-xl font-bold text-[#233D34]"
            >
                <span>Berdasarkan Pendidikan</span>
            </div>
        </div>
        <div style="height: 400px">
            <canvas ref="pendidikanChart" class="w-full mt-20"></canvas>
        </div>
    </section>
</template>
