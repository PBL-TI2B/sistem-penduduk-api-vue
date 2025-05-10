<script setup>
import { onMounted, nextTick } from "vue";
import Chart from "chart.js/auto";

onMounted(async () => {
    await nextTick();
    const ctx = document.getElementById("pendidikanChart")?.getContext("2d");
    if (!ctx) return;

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: [
                "Tidak/Belum Sekolah",
                "Belum Tamat SD/Sederajat",
                "Tamat SD/ Sederajat",
                "SMP/ Sederajat",
                "SMA/ Sederajat",
                "Diploma I/II",
                "Diploma III/ Sarjana Muda",
                "Diploma IV/ Strata I",
                "Strata II",
                "Strata III",
            ],
            datasets: [
                {
                    label: "Jumlah",
                    data: [23, 42, 30, 49, 32, 55, 83, 24, 47, 33],
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
                    ticks: { stepSize: 20 },
                },
            },
        },
    });
});
</script>

<template>
    <section>
        <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-10">
            Berdasarkan Pendidikan
        </h2>
        <canvas id="pendidikanChart" height="150"></canvas>
    </section>
</template>
