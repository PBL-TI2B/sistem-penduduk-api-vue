<script setup lang="ts">
import Button from "@/components/ui/button/Button.vue";
import { ref, unref, onMounted } from "vue";
import BeritaCard from "./BeritaCard.vue";
import { Newspaper } from "lucide-vue-next";
import { apiGet } from "@/utils/api";

const hoverIndex = ref(null);

const newsList = ref([]);
const isLoading = ref(true);
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
            // Sort berdasarkan tanggal_post atau created_at (yang paling baru di atas)
            apiData.sort((a, b) => {
                const dateA = new Date(a.tanggal_post || a.created_at);
                const dateB = new Date(b.tanggal_post || b.created_at);
                return dateB.getTime() - dateA.getTime();
            });

            newsList.value = apiData.slice(0, 4).map((item) => ({
                id: item.id,
                title: item.judul,
                image: item.thumbnail
                    ? `/storage/berita/${item.thumbnail}`
                    : "/images/berita-lain.png",
                date: formatTanggalWIB(item.tanggal_post ?? item.created_at),
                views: item.jumlah_dilihat,
                excerpt: item.konten?.slice(0, 60) + "..." || "",
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
    <section class="pt-5">
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
                    <Link href="/berita"> Jelajahi Berita Desa </Link>
                </Button>
            </div>

            <div
                v-if="newsList.length > 0"
                class="grid grid-cols-1 lg:grid-cols-3 gap-6"
            >
                <!-- Kolom kiri: Berita utama -->
                <BeritaCard
                    :news="newsList[0]"
                    :index="0"
                    :hoverIndex="unref(hoverIndex)"
                    :isLarge="true"
                    @hover="hoverIndex = $event"
                />

                <!-- Kolom kanan: 3 berita kecil -->
                <div class="flex flex-col gap-6">
                    <BeritaCard
                        v-for="(newsItem, i) in newsList.slice(1, 4)"
                        :key="i"
                        :news="newsItem"
                        :index="i + 1"
                        :hoverIndex="unref(hoverIndex)"
                        :isLarge="false"
                        @hover="hoverIndex = $event"
                    />
                </div>
            </div>

            <div v-else-if="isLoading">Loading berita...</div>
            <div v-else>Tidak ada berita ditemukan.</div>
        </div>
    </section>
</template>
