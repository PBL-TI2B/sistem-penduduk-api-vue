<script setup>
import { ref, onMounted } from "vue";
import { apiGet } from "@/utils/api";

const allData = ref([]);
const visibleGallery = ref([]);
const isLoading = ref(true);
const isFetchingMore = ref(false);
const hasData = ref(true);
const currentPage = ref(1);
const lastPage = ref(1);

const fetchGaleri = async (page = 1) => {
    try {
        if (page === 1) isLoading.value = true;
        else isFetchingMore.value = true;

        const res = await apiGet("/galeri?page=" + page);
        const response = res.data;

        lastPage.value = response.last_page;
        currentPage.value = response.current_page;

        const newData = response.data.map((item) => ({
            id: item.id,
            image: item.url_public || "/images/galeri-fallback.png",
            alt: item.judul ?? "Foto Galeri",
        }));

        if (newData.length === 0 && page === 1) {
            hasData.value = false;
        } else {
            allData.value = [...allData.value, ...newData];
            visibleGallery.value = [...visibleGallery.value, ...newData];
        }
    } catch (error) {
        console.error("Gagal mengambil data galeri:", error);
        hasData.value = false;
    } finally {
        isLoading.value = false;
        isFetchingMore.value = false;
    }
};

const handleScroll = () => {
    const bottomReached =
        window.innerHeight + window.scrollY >= document.body.offsetHeight - 100;

    if (
        bottomReached &&
        !isFetchingMore.value &&
        currentPage.value < lastPage.value
    ) {
        fetchGaleri(currentPage.value + 1);
    }
};

onMounted(() => {
    fetchGaleri();
    window.addEventListener("scroll", handleScroll);
});
</script>

<template>
    <section>
        <!-- Loading pertama -->
        <div
            v-if="isLoading"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5"
        >
            <div
                v-for="i in 6"
                :key="'skeleton-' + i"
                class="rounded-xl bg-gray-100 animate-pulse h-72 w-full"
            />
        </div>

        <!-- Empty -->
        <div
            v-else-if="!hasData"
            class="text-center text-gray-500 flex flex-col items-center gap-4 py-10"
        >
            <img
                src="https://placehold.co/300x400"
                alt="Kosong"
                class="w-40 opacity-70"
            />
            <p class="text-lg font-semibold">Belum ada galeri yang tersedia.</p>
            <p class="text-sm text-gray-400">Silakan cek kembali nanti.</p>
        </div>

        <!-- Galeri -->
        <div
            v-else
            class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4"
        >
            <div v-for="image in visibleGallery" :key="image.id">
                <img
                    :src="image.image"
                    :alt="image.alt"
                    class="w-full rounded-xl object-cover"
                    loading="lazy"
                />
            </div>
        </div>

        <!-- Loading saat scroll -->
        <div
            v-if="isFetchingMore"
            class="text-center py-6 text-gray-400 text-sm"
        >
            Memuat lebih banyak...
        </div>
    </section>
</template>
