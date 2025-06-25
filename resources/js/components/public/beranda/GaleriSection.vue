<script setup>
import Button from "@/components/ui/button/Button.vue";
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
                    image: item.url_public
                        ? item.url_public
                        : "/images/galeri-fallback.png",
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
    <section class="lg:px-12">
        <div class="relative">
            <div class="mx-4 max-w-4xl lg:max-w-6xl lg:mx-auto">
                <!-- Header judul + tombol -->
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <div class="flex items-center gap-2">
                            <Images :size="35" class="text-emerald-500" />
                            <h2 class="text-xl md:text-5xl font-bold">
                                Galeri Desa
                            </h2>
                        </div>
                        <p class="text-lg text-gray-600">
                            Temukan berbagai foto dokumentasi menarik terkait
                            Desa Jabung
                        </p>
                    </div>
                    <Button asChild variant="frontend">
                        <Link href="/galeri"> Jelajahi Galeri Desa </Link>
                    </Button>
                </div>
            </div>
            <!-- Video wrapper -->
            <div
                class="relative max-w-6xl mx-4 lg:mx-auto z-20 top-0 right-0 left-0"
            >
                <div class="relative w-full pb-[56.25%]">
                    <!-- Aspect ratio 16:9 -->
                    <iframe
                        class="absolute top-0 left-0 w-full h-full rounded-xl shadow-lg"
                        src="https://www.youtube.com/embed/dPRB8xE6RWA?si=EVSUnFHOKm1Uu25o"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen
                        loading="lazy"
                    ></iframe>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-4 lg:mx-auto py-4">
            <div
                class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4"
            >
                <div v-for="image in galleryList" :key="image.id">
                    <img
                        :src="image.image"
                        :alt="image.alt"
                        class="w-full rounded-xl object-cover"
                        loading="lazy"
                    />
                </div>
            </div>
        </div>
    </section>
</template>
