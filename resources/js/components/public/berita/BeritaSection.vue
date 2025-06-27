<script setup lang="ts">
import { ref, onMounted, watch, computed } from "vue";
import { apiGet } from "@/utils/api";
import BeritaCard from "../beranda/BeritaCard.vue";
import { ChevronLeft, ChevronRight } from "lucide-vue-next"; // pastikan kamu impor ikon ini
import { Button } from "@/components/ui/button"; // ganti sesuai lokasi komponenmu

const newsList = ref([]);
const isLoading = ref(true);
const hasData = ref(true);
const hoverIndex = ref(null);

const currentPage = ref(1);
const lastPage = ref(1);
const perPage = 6; // jumlah berita per halaman

const formatTanggalWIB = (input: string): string => {
    const date = new Date(input);
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
    isLoading.value = true;
    try {
        const res = await apiGet("/berita", {
            status: "publish",
            page: currentPage.value,
            per_page: perPage,
        });
        const data = res.data;
        const items = data.data;

        if (!items.length) {
            hasData.value = false;
            newsList.value = [];
        } else {
            hasData.value = true;
            lastPage.value = data.last_page;

            newsList.value = items.map((item) => ({
                id: item.id,
                uuid: item.uuid,
                title: item.judul,
                slug: item.slug,
                image: item.thumbnail
                    ? `/storage/berita/${item.thumbnail}`
                    : "/images/berita-lain.png",
                date: formatTanggalWIB(item.created_at),
                views: item.jumlah_dilihat,
                excerpt: item.konten.slice(0, 60) + "...",
                author: item.user?.username ?? "Admin",
            }));
        }
    } catch (error) {
        console.error("Gagal mengambil data berita:", error);
        hasData.value = false;
    } finally {
        isLoading.value = false;
    }
};

const visiblePages = computed(() => {
    const total = lastPage.value;
    const current = currentPage.value;
    const range: (number | string)[] = [];

    if (total <= 7) {
        for (let i = 1; i <= total; i++) range.push(i);
    } else {
        if (current <= 4) {
            range.push(1, 2, 3, 4, 5, "...", total);
        } else if (current >= total - 3) {
            range.push(
                1,
                "...",
                total - 4,
                total - 3,
                total - 2,
                total - 1,
                total
            );
        } else {
            range.push(
                1,
                "...",
                current - 1,
                current,
                current + 1,
                "...",
                total
            );
        }
    }

    return range;
});

onMounted(fetchBerita);

watch(currentPage, fetchBerita);
</script>

<template>
    <section>
        <!-- Skeleton Loading -->
        <div
            v-if="isLoading"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5"
        >
            <div
                v-for="i in 3"
                :key="i"
                class="bg-white rounded-xl shadow overflow-hidden"
            >
                <div class="w-full h-60 bg-gray-200"></div>
                <div class="p-4 flex flex-col justify-between w-full space-y-4">
                    <div class="w-3/4 h-5 bg-gray-300 rounded"></div>
                    <div class="w-full h-4 bg-gray-200 rounded"></div>
                    <div class="w-1/2 h-4 bg-gray-200 rounded"></div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div
            v-else-if="!hasData"
            class="text-center text-gray-500 flex flex-col items-center gap-4 py-10"
        >
            <img
                src="https://placehold.co/300x400"
                alt="Kosong"
                class="w-40 opacity-70"
            />
            <p class="text-lg font-semibold">Belum ada berita yang tersedia.</p>
            <p class="text-sm text-gray-400">Silakan cek kembali nanti.</p>
        </div>

        <!-- News List -->
        <div
            v-else
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5"
        >
            <BeritaCard
                v-for="(newsItem, i) in newsList"
                :key="newsItem.id"
                :news="newsItem"
                :index="i"
                :hoverIndex="hoverIndex"
                :isVerticalLayout="true"
                @hover="hoverIndex = $event"
            />
        </div>

        <!-- Pagination Controls -->
        <!-- v-if="hasData && lastPage > 1" -->
        <!-- Pagination Controls -->
        <div class="flex gap-2 justify-center items-center mt-8 flex-wrap">
            <Button
                :disabled="currentPage <= 1"
                variant="ghost"
                @click="currentPage--"
            >
                <ChevronLeft class="w-4 h-4" />
            </Button>

            <Button
                v-for="n in visiblePages"
                :key="n"
                @click="typeof n === 'number' && (currentPage = n)"
                :disabled="n === '...'"
                :class="[
                    'w-[34px] h-[34px] text-sm border rounded-md transition',
                    currentPage === n
                        ? 'bg-gradient-to-r from-emerald-500 to-emerald-600 text-primary-foreground'
                        : 'bg-muted',
                    n === '...' ? 'cursor-default' : 'cursor-pointer',
                ]"
                size="sm"
            >
                {{ n }}
            </Button>

            <Button
                :disabled="currentPage === lastPage"
                variant="ghost"
                @click="currentPage++"
            >
                <ChevronRight class="w-4 h-4" />
            </Button>
        </div>
    </section>
</template>
