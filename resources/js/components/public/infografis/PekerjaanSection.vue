<script setup>
import { onMounted, ref } from "vue";
import Chart from "chart.js/auto";
import axios from "axios";

const chartInstance = ref(null);

const fetchPekerjaanData = async () => {
    try {
        const response = await axios.get("/api/v1/statistik/pekerjaan");

        if (response.data.success) {
            const data = response.data.data;

            const labels = data.map((item) => item.pekerjaan);
            const values = data.map((item) => item.jumlah);

            const colors = [
                "#A78BFA",
                "#FCA5A5",
                "#67E8F9",
                "#FDBA74",
                "#60A5FA",
                "#86EFAC",
                "#D8B4FE",
                "#38BDF8",
                "#6EE7B7",
                "#FCD34D",
                "#C084FC",
            ];

            const ctx = document
                .getElementById("pekerjaanChart")
                ?.getContext("2d");
            if (!ctx) return;

            // Hancurkan chart sebelumnya jika ada
            if (chartInstance.value) {
                chartInstance.value.destroy();
            }

            chartInstance.value = new Chart(ctx, {
                type: "pie",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            data: values,
                            backgroundColor: colors.slice(0, data.length),
                            radius: "100%",
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
                                        ((value / total) * 100).toFixed(2) +
                                        "%";
                                    return `${context.label}: ${value} (${percentage})`;
                                },
                            },
                        },
                    },
                },
            });
        }
    } catch (error) {
        console.error("Gagal ambil data statistik pekerjaan:", error);
    }
};

onMounted(() => {
    fetchPekerjaanData();
});
</script>

<template>
    <section class="bg-gray shadow-md rounded-xl p-6">
        <!-- <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-10">
            Berdasarkan Pekerjaan
        </h2> -->
        <div
            class="flex items-center gap-2 bg-[#e7fcee] text-green-700 font-semibold px-4 py-2 rounded-full w-fit mb-4"
        >
            <div class="w-1 h-6 bg-green-500 rounded"></div>
            <div
                class="flex items-center gap-2 md:text-lg font-bold text-[#233D34]"
            >
                <span>Berdasarkan Pekerjaan</span>
            </div>
        </div>
        <div class="h-[400px] flex items-center justify-center">
            <canvas id="pekerjaanChart" class="max-w-full max-h-full"></canvas>
        </div>
    </section>
</template>
