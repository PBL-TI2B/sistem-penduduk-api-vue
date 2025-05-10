<script setup>
import Chart from "chart.js/auto";
import { onMounted } from "vue";

onMounted(() => {
    // chart kelahiran kematian
    const ctxMatiLahir = document
        .getElementById("kelahiranKematianChart")
        ?.getContext("2d");
    if (!ctxMatiLahir) return;

    new Chart(ctxMatiLahir, {
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
                    data: [29, 44, 47, 31, 18, 44, 23, 45, 8, 32, 40, 16],
                    borderColor: "#F59E0B", // amber-500
                    backgroundColor: "#F59E0B",
                    fill: false,
                    tension: 0.3,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                },
                {
                    label: "Kematian",
                    data: [47, 25, 13, 44, 22, 22, 25, 11, 42, 28, 21, 20],
                    borderColor: "#14532D", // emerald-900
                    backgroundColor: "#14532D",
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
                legend: {
                    position: "bottom",
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
});
</script>
<template>
    <section>
        <div class="flex items-center justify-between mb-4 mt-10">
            <h2 class="text-xl font-bold text-[#233D34]">
                Angka Kelahiran dan Kematian
            </h2>
            <span class="text-sm md:text-lg text-gray-500">Tahun 2024</span>
        </div>
        <canvas id="kelahiranKematianChart" height="100"></canvas>
    </section>
</template>
