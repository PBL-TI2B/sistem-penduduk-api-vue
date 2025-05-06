<script setup>
import Button from "@/components/ui/button/Button.vue";
import { Images } from "lucide-vue-next";

const images = [
    {
        src: "/images/kepala-desa.png",
        alt: "Galeri 1",
    },
    {
        src: "/images/kantor-desa.png",
        alt: "Galeri 2",
    },
    {
        src: "/images/berita-utama.png",
        alt: "Galeri 3",
    },
    {
        src: "/images/kepala-desa.png",
        alt: "Galeri 4",
    },
    {
        src: "/images/berita-lain.png",
        alt: "Galeri 5",
    },
    {
        src: "/images/kantor-desa.png",
        alt: "Galeri 6",
    },
];
</script>

<template>
    <section>
        <div class="relative">
            <div class="mx-4 max-w-6xl lg:mx-auto">
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
                        <Link href="../../pages/berita">
                            Jelajahi Galeri Desa
                        </Link>
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
                <div v-for="(image, index) in images" :key="index" class="mb-4">
                    <img
                        :src="image.src"
                        :alt="image.alt"
                        class="w-full rounded-xl object-cover"
                    />
                </div>
            </div>
        </div>
    </section>
</template>
