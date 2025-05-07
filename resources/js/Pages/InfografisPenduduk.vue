<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import { motion } from "motion-v";
import { onMounted } from "vue";
import Chart from "chart.js/auto";

import IslamIcon from "@/images/islam.svg";
import KristenIcon from "@/images/kristen.svg";
import KatolikIcon from "@/images/katolik.svg";
import HinduIcon from "@/images/hindu.svg";
import BuddhaIcon from "@/images/budha.svg";
import KonghucuIcon from "@/images/konghucu.svg";

defineOptions({
    layout: PublicLayout,
});

onMounted(() => {
    // chart umur
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

    // chart pendidikan
    const ctxPendidikan = document
        .getElementById("pendidikanChart")
        .getContext("2d");

    const pendidikanLabels = [
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
    ];

    const pendidikanData = [23, 42, 30, 49, 32, 55, 83, 24, 47, 33];

    new Chart(ctxPendidikan, {
        type: "bar",
        data: {
            labels: pendidikanLabels,
            datasets: [
                {
                    label: "Jumlah",
                    data: pendidikanData,
                    backgroundColor: "rgba(75, 85, 99, 0.8)", // warna bg: slate-600
                    borderRadius: 4,
                    borderSkipped: false,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    enabled: true,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 20,
                    },
                },
            },
        },
    });

    // chart pekerjaan
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
    <Head title=" - Infografis Penduduk" />
    <div class="bg-gray-50 min-h-screen px-6 py-8 pt-15">
        <section class="flex flex-col max-w-6xl mx-auto py-8">
            <!-- Judul & Navigasi -->
            <div
                class="flex justify-between items-center flex-wrap gap-4 mt-6 mb-8"
            >
                <!-- Judul -->
                <h1 class="text-3xl font-bold text-[#E5A025]">
                    INFOGRAFIS<br class="sm:hidden" />
                    DESA JABUNG
                </h1>

                <!-- Navigasi Tab -->
                <div class="flex space-x-6">
                    <a href="../infografis/penduduk">
                        <div
                            class="flex items-center space-x-2 text-gray-800 border-b-2 border-[#E5A025] pb-1 hover:text-[#E5A025] transition"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5s-3 1.34-3 3 1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"
                                />
                            </svg>
                            <span class="font-medium">Penduduk</span>
                        </div>
                    </a>

                    <a href="../infografis/bansos">
                        <div
                            class="flex items-center space-x-2 text-gray-500 hover:text-gray-800 hover:border-b-2 hover:border-[#E5A025] pb-1 transition"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M20 6H4c-1.1 0-2 .9-2 2v11h2v-1h16v1h2V8c0-1.1-.9-2-2-2zm0 10H4V8h16v8zM6 10h5v5H6z"
                                />
                            </svg>
                            <span class="font-medium">Bansos</span>
                        </div>
                    </a>
                </div>
            </div>
            <!-- section deskripsi -->
            <div class="flex justify-between items-start mt-8 mb-6">
                <div class="max-w">
                    <h2 class="text-[#2FB586] font-bold text-2xl mb-2">
                        DEMOGRAFI PENDUDUK
                    </h2>
                    <p class="text-sm md:text-lg text-gray-600 mb-2">
                        Memberikan informasi lengkap mengenai karakteristik
                        demografi penduduk suatu wilayah. Mulai dari jumlah
                        penduduk, usia, jenis kelamin, tingkat pendidikan,
                        pekerjaan, agama, dan aspek penting lainnya yang
                        menggambarkan komposisi populasi secara rinci.
                    </p>
                </div>
            </div>

            <!-- Demografi Penduduk -->
            <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-8">
                Jumlah Penduduk dan Kepala Keluarga
            </h2>
            <div
                class="grid grid-cols-2 md:grid-cols-2 gap-4 text-white text-center"
            >
                <div
                    class="bg-[#40798C] p-4 rounded-[20px] flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
                >
                    <img
                        src="@/images/ttlpenduduk.png"
                        alt="Total Penduduk"
                        class="w-12 h-12"
                    />
                    <div>
                        <p class="text-sm md:text-lg">TOTAL PENDUDUK</p>
                        <p class="text-xl font-bold">1.150 Jiwa</p>
                    </div>
                </div>
                <div
                    class="bg-[#70A9A1] p-4 rounded-[20px] flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
                >
                    <img
                        src="@/images/kepalakeluarga.png"
                        alt="Kepala Keluarga"
                        class="w-12 h-12"
                    />
                    <div>
                        <p class="text-sm md:text-lg">KEPALA KELUARGA</p>
                        <p class="text-xl font-bold">304 Jiwa</p>
                    </div>
                </div>
                <div
                    class="bg-[#CD8B76] p-4 rounded-[20px] flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
                >
                    <img
                        src="@/images/laki.png"
                        alt="Laki-Laki"
                        class="w-12 h-12"
                    />
                    <div>
                        <p class="text-sm md:text-lg">LAKI-LAKI</p>
                        <p class="text-xl font-bold">607 Jiwa</p>
                    </div>
                </div>
                <div
                    class="bg-[#734B5E] p-4 rounded-[20px] flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
                >
                    <img
                        src="@/images/perempuan.png"
                        alt="Perempuan"
                        class="w-12 h-12"
                    />
                    <div>
                        <p class="text-sm md:text-lg">PEREMPUAN</p>
                        <p class="text-xl font-bold">543 Jiwa</p>
                    </div>
                </div>
            </div>

            <!-- Grafik kelompok umur -->
            <section>
                <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-10">
                    Berdasarkan Kelompok Umur
                </h2>

                <canvas id="umurChart" height="100"></canvas>
            </section>

            <!-- Pendidikan -->
            <section>
                <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-10">
                    Berdasarkan Pendidikan
                </h2>
                <canvas id="pendidikanChart" height="150"></canvas>
            </section>

            <!-- Pekerjaan -->
            <section>
                <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-10">
                    Berdasarkan Pekerjaan
                </h2>
                <canvas id="pekerjaanChart" height="150"></canvas>
            </section>

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

            <!-- Kelahiran & Kematian -->
            <section>
                <div class="flex items-center justify-between mb-4 mt-10">
                    <h2 class="text-xl font-bold text-[#233D34]">
                        Angka Kelahiran dan Kematian
                    </h2>
                    <span class="text-sm md:text-lg text-gray-500"
                        >Tahun 2024</span
                    >
                </div>
                <canvas id="kelahiranKematianChart" height="100"></canvas>
            </section>
        </section>
    </div>
</template>
