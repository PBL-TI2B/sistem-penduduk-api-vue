<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { apiGet } from "@/utils/api";

const newsList = ref([]);
const isLoading = ref(true);
const hasData = ref(true);
const router = useRouter();

const fetchBerita = async () => {
    try {
        const res = await apiGet("/berita");
        const apiData = res.data.data.data;

        if (!apiData || apiData.length === 0) {
            hasData.value = false;
        } else {
            // Ambil 5 berita terbaru
            newsList.value = apiData.slice(0, 5).map((item) => ({
                id: item.id,
                title: item.judul,
                image: item.thumbnail
                    ? `/storage/${item.thumbnail}`
                    : "/images/berita-lain.png",
                date: item.tanggal_post,
                excerpt: item.konten.slice(0, 60) + "...",
            }));
        }
    } catch (error) {
        console.error("Gagal mengambil data berita:", error);
        hasData.value = false;
    } finally {
        isLoading.value = false;
    }
};

const goToDetail = (id) => {
    router.push(`/berita/${id}`);
};

onMounted(fetchBerita);
</script>

<template>
    <aside class="space-y-4 w-full lg:w-80 lg:sticky lg:top-24 self-start">
        <h3 class="text-lg font-semibold border-b pb-2 text-[#E5A025]">
            Berita Lainnya
        </h3>

        <div v-if="isLoading" class="text-gray-500">Memuat berita...</div>
        <div v-else-if="!hasData" class="text-gray-500">Belum ada berita.</div>

        <div v-else class="space-y-4">
            <div
                v-for="(news, index) in newsList"
                :key="index"
                class="flex gap-4 cursor-pointer hover:bg-gray-100 p-2 rounded transition"
                @click="goToDetail(news.id)"
            >
                <img
                    :src="news.image"
                    class="w-24 h-24 object-cover rounded"
                    :alt="news.title"
                />
                <div class="text-sm md:text-base">
                    <p
                        class="font-medium leading-snug text-gray-700 hover:text-[#E5A025] transition"
                    >
                        {{ news.title }}
                    </p>
                    <p class="text-gray-500 text-xs mt-1">
                        {{ news.date }}
                    </p>
                    <p class="text-gray-800 text-xs mt-1">
                        {{ news.excerpt }}
                    </p>
                </div>
            </div>
        </div>
    </aside>
</template>
