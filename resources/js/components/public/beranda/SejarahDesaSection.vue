<script setup>
import { FileClock } from "lucide-vue-next";
</script>

<template>
    <section class="lg:px-12">
        <div class="pb-6 md:pb-12 mx-4 max-w-6xl lg:mx-auto">
            <div class="container">
                <div class="flex items-center gap-2">
                    <FileClock :size="35" class="text-emerald-500" />
                    <h2 class="text-xl md:text-5xl font-bold mb-6">
                        Sejarah Desa
                    </h2>
                </div>
                <p class="text-sm md:text-lg text-gray-600 mb-2">
                    Selamat Datang di Bumi Desa Jabung - Gantiwarno, Klaten.
                </p>
                <p class="text-sm md:text-lg text-gray-600 mb-2">
                    Desa Jabung terletak di Kecamatan Gantiwarno, Klaten, Jawa
                    Tengah. Jabung menjadi salah satu dari 16 desa di Kecamatan
                    Gantiwarno. Wilayahnya kini meliputi 28 RT dan 13 RW dengan
                    total jumlah pendudukan berdasarkan data tahun 2023 sebanyak
                    3.450 jiwa.
                </p>
                <p class="text-sm md:text-lg text-gray-600">
                    Desa Jabung menjadi salah satu pusat kegiatan pertanian di
                    kecamatan, dengan hasil pertanian seperti padi, jagung,
                    tembakau, dan palawija menjadi komoditas utama yang
                    dihasilkan oleh masyarakat setempat. Infrastruktur desa yang
                    baik serta akses jalan yang memadai juga mendukung mobilitas
                    dan distribusi hasil pertanian ke pasar-pasar di sekitar
                    wilayah Kabupaten Klaten.
                </p>
            </div>
        </div>
    </section>
</template>
