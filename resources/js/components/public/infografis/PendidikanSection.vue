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
                    },
                ],
            },
            options: {
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
    <section>
        <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-10">
            Berdasarkan Pendidikan
        </h2>
        <canvas ref="pendidikanChart" height="150"></canvas>
    </section>
</template>
