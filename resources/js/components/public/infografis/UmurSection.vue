<script setup>
import { onMounted } from "vue";
import Chart from "chart.js/auto";
// chart umur
onMounted(() => {
    const ctxUmur = document.getElementById("umurChart")?.getContext("2d");
    if (!ctxUmur) return;

    new Chart(ctxUmur, {
        type: "bar",
        data: {
            labels: [
                "0-5",
                "6-10",
                "11-15",
                "16-20",
                "21-25",
                "26-30",
                "31-35",
                "36-40",
                "41-45",
                "46-50",
                "51-55",
                "56-60",
                "61-65",
                "66-70",
                "71-75",
                "76-80",
                "81-85",
                "86+",
            ],
            datasets: [
                {
                    label: "Laki-Laki",
                    data: [
                        11, 15, 12, 60, 51, 98, 99, 80, 34, 53, 93, 35, 72, 39,
                        42, 97, 58, 75,
                    ],
                    backgroundColor: "#3CB371",
                    stack: "Stack 0",
                },
                {
                    label: "Perempuan",
                    data: [
                        17, 27, 72, 24, 54, 54, 93, 63, 58, 65, 28, 93, 35, 15,
                        39, 78, 80, 52,
                    ],
                    backgroundColor: "#FBC02D",
                    stack: "Stack 0",
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "bottom",
                },
                tooltip: {
                    mode: "index",
                    intersect: false,
                },
            },
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Jumlah Penduduk",
                    },
                },
            },
        },
    });
});
</script>
<template>
    <!-- Grafik kelompok umur -->
    <section>
        <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-10">
            Berdasarkan Kelompok Umur
        </h2>

        <canvas id="umurChart" height="100"></canvas>
    </section>
</template>
