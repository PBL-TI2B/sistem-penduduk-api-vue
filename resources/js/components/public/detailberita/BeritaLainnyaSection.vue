<script setup>
import { ref, onMounted, unref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { apiGet } from "@/utils/api";
import BeritaCard from "../beranda/BeritaCard.vue";

const newsList = ref([]);
const hoverIndex = ref(null);
const { slug: currentSlug } = usePage().props;
const isLoading = ref(true);
const hasData = ref(true);

const formatTanggalWIB = (input) => {
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
        const res = await apiGet("/berita", {
            status: "publish",
        });

        const apiData = res.data.data;
        console.log(apiData);

        if (!apiData || apiData.length === 0) {
            hasData.value = false;
        } else {
            // Filter berita yang bukan yang sedang dibuka
            const filtered = apiData.filter(
                (item) => item.slug !== currentSlug
            );

            if (filtered.length === 0) {
                hasData.value = false;
            } else {
                newsList.value = filtered.slice(0, 5).map((item) => ({
                    id: item.id,
                    title: item.judul,
                    slug: item.slug,
                    image: item.thumbnail
                        ? `/storage/berita/${item.thumbnail}`
                        : "/images/berita-lain.png",
                    date: formatTanggalWIB(
                        item.tanggal_post ?? item.created_at
                    ),
                    views: item.jumlah_dilihat,
                    excerpt: item.konten?.slice(0, 200) + "..." || "",
                    author: item.user?.username ?? "Admin",
                }));
            }
        }
    } catch (error) {
        console.error("Gagal mengambil data berita:", error);
        hasData.value = false;
    } finally {
        isLoading.value = false;
    }
};

const goToDetail = (id) => {
    router.visit(`/berita/${id}`);
};

onMounted(fetchBerita);
</script>

<template>
    <aside class="space-y-4 w-full lg:w-80 lg:sticky lg:top-24 self-start">
        <h3 class="text-lg font-semibold border-b pb-2 text-emerald-600">
            Berita Lainnya
        </h3>

        <div v-if="isLoading">
            <div class="flex flex-col gap-6">
                <div
                    v-for="i in 5"
                    :key="i"
                    class="bg-white rounded-xl shadow overflow-hidden flex"
                >
                    <div class="w-24 h-24 bg-gray-200"></div>
                    <div
                        class="p-4 flex flex-col justify-between w-full space-y-2"
                    >
                        <div class="w-3/4 h-4 bg-gray-300 rounded"></div>
                        <div class="w-full h-3 bg-gray-200 rounded"></div>
                        <div class="w-1/2 h-3 bg-gray-200 rounded"></div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else-if="!hasData" class="text-gray-500">Belum ada berita.</div>

        <div v-else class="space-y-4">
            <BeritaCard
                v-for="(newsItem, i) in newsList"
                :key="i"
                :news="newsItem"
                :index="i + 1"
                :hoverIndex="unref(hoverIndex)"
                :isLarge="false"
                @hover="hoverIndex = $event"
            />
        </div>
    </aside>
</template>
