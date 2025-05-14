<script setup>
import { ref, onMounted } from "vue";
import { apiGet } from "@/utils/api"; // pastikan ini helper axios-mu

import { CalendarDays, Eye, User } from "lucide-vue-next";

const newsList = ref([]);
const isLoading = ref(true);
const isLarge = ref(true);

const fetchBerita = async () => {
    try {
        const res = await apiGet("/berita");
        newsList.value = res.data.data.data.map((item) => ({
            id: item.id,
            title: item.judul,
            image: item.thumbnail
                ? `/storage/${item.thumbnail}`
                : "/images/berita-lain.png",
            date: item.tanggal_post,
            views: item.jumlah_dilihat,
            excerpt: item.konten.slice(0, 60) + "...",
            author: item.author ?? "Admin",
        }));
    } catch (error) {
        console.error("Gagal mengambil data berita:", error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(fetchBerita);
</script>

<template>
    <section>
        <div v-if="isLoading" class="text-gray-500">Memuat berita...</div>

        <div
            v-else
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5"
        >
            <div
                v-for="news in newsList"
                :key="news.id"
                class="bg-white rounded-xl shadow overflow-hidden drop-shadow-md hover:drop-shadow-xl"
            >
                <router-link :to="`/detailberita/${news.id}`">
                    <img
                        :src="news.image"
                        alt="Berita"
                        class="w-full h-48 object-cover"
                    />
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
                </router-link>
            </div>
        </div>
    </section>
</template>
