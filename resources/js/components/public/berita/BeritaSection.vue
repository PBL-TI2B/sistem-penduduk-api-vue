<script setup>
import { ref } from "vue";
import { CalendarDays, Eye, User } from "lucide-vue-next";

const newsList = ref([
    {
        id: 1,
        date: "2025-05-10",
        views: 10,
        title: "Pemerintah Desa Jabung Melakukan Bagi Baksos",
        excerpt: "Pemerintah Desa Jabung baru ini melakukan bagi baksos ke ...",
        author: "Admin",
        image: "/images/berita-lain.png",
    },
    {
        id: 2,
        date: "2025-05-07",
        views: 25,
        title: "Kegiatan Posyandu di RW 01 Desa Jabung",
        excerpt: "Kegiatan Posyandu rutin dilakukan di balai RW 01 ...",
        author: "Admin",
        image: "/images/berita-lain.png",
    },
    // Tambah data lain sesuai kebutuhan
]);

const isLarge = ref(true);
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <div
            v-for="news in newsList"
            :key="news.id"
            class="bg-white rounded-xl shadow overflow-hidden drop-shadow-md hover:drop-shadow-xl"
        >
            <a href="../detailberita">
                <img :src="news.image" alt="Berita" />
                <div class="px-4 lg:px-6 pb-4">
                    <h3
                        class="font-semibold text-sm md:text-lg text-gray-600 mt-4"
                    >
                        {{ news.title }}
                    </h3>

                    <div
                        class="text-xs text-gray-500 flex items-center gap-4 mt-2"
                    >
                        <div class="flex items-center gap-1">
                            <CalendarDays
                                :size="isLarge ? 12 : 8"
                                class="text-emerald-600"
                            />
                            <span>{{ news.date }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <Eye
                                :size="isLarge ? 12 : 8"
                                class="text-emerald-600"
                            />
                            <span>{{ news.views }} Kali Dilihat</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <User
                                :size="isLarge ? 12 : 8"
                                class="text-emerald-600"
                            />
                            <span>{{ news.author }}</span>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 mt-2">
                        {{ news.excerpt }}
                    </p>
                </div>
            </a>
        </div>
    </div>
</template>
