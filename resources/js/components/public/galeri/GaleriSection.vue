<script setup>
import { ref, onMounted } from "vue";
import { apiGet } from "@/utils/api";

const galleryList = ref([]);
const isLoading = ref(true);
const hasData = ref(true);

const fetchGaleri = async () => {
    try {
        const res = await apiGet("/galeri");
        const apiData = res.data.data;

        if (apiData.length === 0) {
            hasData.value = false;
        } else {
            galleryList.value = apiData
                .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
                .map((item) => ({
                    id: item.id,
                    image: item.foto ? item.foto : "fallback.png",
                    alt: item.judul ?? "Foto Galeri",
                }));
        }
    } catch (error) {
        console.error("Gagal mengambil data galeri:", error);
        hasData.value = false;
    } finally {
        isLoading.value = false;
    }
};

onMounted(fetchGaleri);
</script>

<template>
    <section>
        <!-- Loading -->
        <div v-if="isLoading" class="text-gray-500">Memuat galeri...</div>

        <!-- Jika tidak ada data -->
        <div v-else-if="!hasData" class="text-gray-500">Belum ada foto.</div>

        <!-- Galeri tersedia -->
        <div
            v-else
            class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4"
        >
            <div v-for="image in galleryList" :key="image.id">
                <img
                    :src="image.image"
                    :alt="image.alt"
                    class="w-full rounded-xl object-cover"
                />
            </div>
        </div>
    </section>
</template>
