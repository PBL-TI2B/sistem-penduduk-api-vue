<script setup>
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
</template>
