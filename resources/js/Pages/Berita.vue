<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import BeritaSection from "@/components/public/berita/BeritaSection.vue";
import { motion } from "motion-v";

defineOptions({
    layout: PublicLayout,
});
</script>

<template>
    <Head title=" - Berita Desa" />
    <div class="bg-gray-50 min-h-screen px-6 md:px-48 py-8 pt-15">
        <div class="flex flex-col max-w-6xl mx-auto py-8">
            <div class="absolute top-0 left-0 w-full z-0">
                <svg
                    class="w-full h-[1000px] md:h-[600px]"
                    viewBox="0 0 1440 200"
                    preserveAspectRatio="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <defs>
                        <linearGradient
                            id="grad1"
                            x1="50%"
                            y1="0%"
                            x2="50%"
                            y2="100%"
                        >
                            <stop
                                offset="20%"
                                style="
                                    stop-color: oklch(84.5% 0.143 164.978);
                                    stop-opacity: 1;
                                "
                            />
                            <stop
                                offset="80%"
                                style="
                                    stop-color: oklch(59.6% 0.145 163.225);
                                    stop-opacity: 1;
                                "
                            />
                        </linearGradient>
                    </defs>
                    <path
                        fill="url(#grad1)"
                        d="M0,100 C360,160 1080,80 1440,120 L1440,0 L0,0 Z"
                    />
                </svg>
            </div>
            <div
                class="relative z-10 max-w-5xl mx-auto px-6 py-10 md:py-20 text-center text-white"
            >
                <motion.h1
                    class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 drop-shadow"
                    :initial="{ opacity: 0, y: -40 }"
                    :animate="{ opacity: 1, y: 0 }"
                    :transition="{ duration: 1, delay: 0.2, ease: 'easeOut' }"
                >
                    Berita Desa Jabung
                </motion.h1>
                <motion.h2
                    class="md:text-xl mb-4 mt-4 drop-shadow"
                    :initial="{ opacity: 0, y: 40 }"
                    :animate="{ opacity: 1, y: 0 }"
                    :transition="{ duration: 1, delay: 0.2, ease: 'easeOut' }"
                >
                    Informasi Artikel dan Pengumuman Terbaru Desa Jabung
                </motion.h2>
            </div>
        </div>
        <div class="relative z-10">
            <BeritaSection />
        </div>
    </div>
</template>
