<script setup lang="ts">
import Button from "@/components/ui/button/Button.vue";
import { ref, unref } from "vue";
import BeritaCard from "./BeritaCard.vue";
import { Newspaper } from "lucide-vue-next";

const hoverIndex = ref(null);

const news = [
    {
        title: "Pemerintah Desa Jabung melakukan bagi baksos",
        date: "2 Februari 2025",
        views: 10,
        author: "Admin",
        image: "/images/berita-utama.png",
        description:
            "Pemerintah Desa Jabung baru ini melakukan bagi baksos bagi keluarga terdaftar pada xxxxx xxxxx xxxx xxxxxxx Selain pembagian makanan, acara ini juga menjadi ajang sosialisasi pentingnya perilaku hidup bersih dan sehat.",
    },
    {
        title: "Pemerintah Desa Jabung melakukan bagi baksos",
        date: "2 Februari 2025",
        views: 10,
        author: "Admin",
        image: "/images/berita-lain.png",
        description:
            "Pemerintah Desa Jabung baru ini melakukan bagi baksos bagi keluarga terdaftar pada...",
    },
    {
        title: "Pemerintah Desa Jabung melakukan bagi baksos",
        date: "2 Februari 2025",
        views: 10,
        author: "Admin",
        image: "/images/berita-lain.png",
        description:
            "Pemerintah Desa Jabung baru ini melakukan bagi baksos bagi keluarga terdaftar pada...",
    },
    {
        title: "Pemerintah Desa Jabung melakukan bagi baksos",
        date: "2 Februari 2025",
        views: 10,
        author: "Admin",
        image: "/images/berita-lain.png",
        description:
            "Pemerintah Desa Jabung baru ini melakukan bagi baksos bagi keluarga terdaftar pada...",
    },
];
</script>

<template>
    <section class="bg-gray-100 pt-5">
        <div class="mx-4 max-w-6xl lg:mx-auto">
            <!-- Header judul + tombol -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <div class="flex items-center gap-2">
                        <Newspaper :size="35" class="text-emerald-500" />
                        <h2 class="text-xl md:text-5xl font-bold">
                            Berita Desa
                        </h2>
                    </div>
                    <p class="text-lg text-gray-600">
                        Baca berbagai berita terbaru terkait Desa Jabung
                    </p>
                </div>
                <Button asChild variant="frontend">
                    <Link href="../../pages/berita">
                        Jelajahi Berita Desa
                    </Link>
                </Button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Kolom kiri: Berita utama -->
                <BeritaCard
                    :news="news[0]"
                    :index="0"
                    :hoverIndex="unref(hoverIndex)"
                    :isLarge="true"
                    @hover="hoverIndex = $event"
                />

                <!-- Kolom kanan: 3 berita kecil -->
                <div class="flex flex-col gap-4">
                    <BeritaCard
                        v-for="(newsItem, i) in news.slice(1, 4)"
                        :key="i"
                        :news="newsItem"
                        :index="i + 1"
                        :hoverIndex="unref(hoverIndex)"
                        :isLarge="false"
                        @hover="hoverIndex = $event"
                    />
                </div>
            </div>
        </div>
    </section>
</template>
