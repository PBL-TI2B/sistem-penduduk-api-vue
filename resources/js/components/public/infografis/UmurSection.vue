<script setup>
import { onMounted, ref } from "vue";
import Chart from "chart.js/auto";

const fetchUmurData = async () => {
    try {
        const response = await fetch(
            "http://127.0.0.1:8000/api/v1/statistik/umur"
        );
        const result = await response.json();

        if (result.success) {
            const umurLabels = result.data.map((item) => item.umur);
            const lakiLakiData = result.data.map((item) => item.L);
            const perempuanData = result.data.map((item) => item.P);

            return { umurLabels, lakiLakiData, perempuanData };
        } else {
            console.error("Gagal mendapatkan data:", result.message);
            return { umurLabels: [], lakiLakiData: [], perempuanData: [] };
        }
    } catch (error) {
        console.error("Error saat fetch data:", error);
        return { umurLabels: [], lakiLakiData: [], perempuanData: [] };
    }
};

onMounted(async () => {
    const ctxUmur = document.getElementById("umurChart")?.getContext("2d");
    if (!ctxUmur) return;

    const { umurLabels, lakiLakiData, perempuanData } = await fetchUmurData();

    new Chart(ctxUmur, {
        type: "bar",
        data: {
            labels: umurLabels,
            datasets: [
                {
                    label: "Laki-Laki",
                    data: lakiLakiData,
                    backgroundColor: "#3CB371",
                    stack: "Stack 0",
                },
                {
                    label: "Perempuan",
                    data: perempuanData,
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
