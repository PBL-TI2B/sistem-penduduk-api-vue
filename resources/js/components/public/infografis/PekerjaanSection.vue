<script setup>
import { onMounted } from "vue";
import Chart from "chart.js/auto";

// chart pekerjaan
onMounted(() => {
    const ctxPekerjaan = document
        .getElementById("pekerjaanChart")
        ?.getContext("2d");
    if (!ctxPekerjaan) return;

    const pekerjaanLabels = [
        "Pelajar/Mahasiswa",
        "Belum/Tidak Bekerja",
        "Mengurus Rumah Tangga",
        "Karyawan Swasta",
        "Nelayan/Perikanan",
        "Petani/Pekebun",
        "Wiraswasta",
        "ASN",
        "Tenaga Medis",
    ];

    const pekerjaanData = [18, 47, 11, 91, 37, 68, 21, 68, 63];

    const pekerjaanColors = [
        "#A78BFA", // Pelajar/Mahasiswa
        "#FCA5A5", // Belum/Tidak Bekerja
        "#67E8F9", // Mengurus Rumah Tangga
        "#FDBA74", // Karyawan Swasta
        "#60A5FA", // Nelayan
        "#86EFAC", // Petani
        "#D8B4FE", // Wiraswasta
        "#38BDF8", // ASN
        "#6EE7B7", // Tenaga Medis
    ];

    new Chart(ctxPekerjaan, {
        type: "pie",
        data: {
            labels: pekerjaanLabels,
            datasets: [
                {
                    data: pekerjaanData,
                    backgroundColor: pekerjaanColors,
                    radius: "50%",
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "right",
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const total = context.dataset.data.reduce(
                                (a, b) => a + b,
                                0
                            );
                            const value = context.parsed;
                            const percentage =
                                ((value / total) * 100).toFixed(2) + "%";
                            return `${context.label}: ${value} (${percentage})`;
                        },
                    },
                },
            },
        },
    });
});
</script>

<template>
    <section>
        <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-10">
            Berdasarkan Pekerjaan
        </h2>
        <canvas id="pekerjaanChart" height="150"></canvas>
    </section>
</template>
