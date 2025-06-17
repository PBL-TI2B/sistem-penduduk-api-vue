<script setup lang="ts">
import { ref, onMounted } from "vue";
import { apiGet } from "@/utils/api";

import { CalendarDays, Eye, User } from "lucide-vue-next";

const newsList = ref([]);
const isLoading = ref(true);
const isLarge = ref(true);
const hasData = ref(true);

const formatTanggalWIB = (input: string): string => {
    const date = new Date(input);

    // Ubah ke waktu Indonesia (WIB = UTC+7)
    const utc = date.getTime() + date.getTimezoneOffset() * 60000;
    const wibTime = new Date(utc + 7 * 60 * 60000);

    const day = String(wibTime.getDate()).padStart(2, "0");
    const month = String(wibTime.getMonth() + 1).padStart(2, "0");
    const year = wibTime.getFullYear();
    const hours = String(wibTime.getHours()).padStart(2, "0");
    const minutes = String(wibTime.getMinutes()).padStart(2, "0");

    return `${day}/${month}/${year}, ${hours}.${minutes} WIB`;
};

const fetchBerita = async () => {
    try {
        const res = await apiGet("/berita");
        const apiData = res.data.data;

        if (apiData.length === 0) {
            hasData.value = false;
        } else {
            // Urutkan berdasarkan tanggal paling baru
            apiData.sort((a, b) => {
                const dateA = new Date(a.tanggal_post || a.created_at);
                const dateB = new Date(b.tanggal_post || b.created_at);
                return dateB.getTime() - dateA.getTime(); // descending
            });

            newsList.value = apiData.map((item) => ({
                id: item.id,
                uuid: item.uuid,
                title: item.judul,
                image: item.thumbnail
                    ? `/storage/berita/${item.thumbnail}`
                    : "/images/berita-lain.png",
                date: formatTanggalWIB(item.tanggal_post ?? item.created_at),
                views: item.jumlah_dilihat,
                excerpt: item.konten.slice(0, 60) + "...",
                author: item.user?.name ?? "Admin",
            }));
        }
    } catch (error) {
        console.error("Gagal mengambil data berita:", error);
        hasData.value = false;
    } finally {
        isLoading.value = false;
    }
};

onMounted(fetchBerita);
</script>

<template>
    <section>
        <div v-if="isLoading" class="text-gray-500">Memuat berita...</div>
        <div v-else-if="!hasData" class="text-gray-500">Belum ada berita.</div>

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
