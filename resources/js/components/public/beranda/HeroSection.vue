<script setup>
import { motion } from "motion-v";
</script>

<style scoped>
.image-hero {
    object-fit: cover;
    height: 100vh;
    -webkit-mask-image: -webkit-gradient(
        linear,
        left top,
        left bottom,
        from(rgba(0, 0, 0, 1)),
        to(rgba(0, 0, 0, 0))
    );
    mask-image: linear-gradient(
        to bottom,
        rgba(0, 0, 0, 1) 70%,
        transparent 100%
    );
    overflow: hidden;
}
</style>

<template>
    <motion.section
        class="image-hero relative bg-cover bg-center h-[420px] sm:h-[540px] md:h-[760px] lg:h-[900px]"
        style="background-image: url('/images/kantor-desa.png')"
        :initial="{ opacity: 0, scale: 1.05 }"
        :animate="{ opacity: 1, scale: 1 }"
        :exit="{ opacity: 0, scale: 0.95 }"
        :transition="{ duration: 1, ease: 'easeOut' }"
    >
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div
            class="absolute inset-0 flex flex-col justify-center lg:justify-start items-center text-white text-center"
        >
            <motion.h2
                class="mx-4 mt-32 md:mt-32 lg:mt-60 mb-2 text-6xl md:text-8xl font-italianno"
                :initial="{ opacity: 0, y: 40 }"
                :animate="{ opacity: 1, y: 0 }"
                :transition="{ duration: 1, delay: 0.2, ease: 'easeOut' }"
            >
                Selamat Datang
            </motion.h2>
            <motion.h3
                class="mx-4 text-md md:text-3xl font-bold md:mx-2 mt-4"
                :initial="{ opacity: 0, y: -30 }"
                :animate="{ opacity: 1, y: 0 }"
                :transition="{ duration: 1, delay: 0.4 }"
            >
                DESA JABUNG KECAMATAN GANTIWARNO
                <br />
                KABUPATEN KLATEN
            </motion.h3>
            <motion.p
                class="mx-4 text-sm md:text-2xl mt-2 md:mt-9 font-medium"
                :initial="{ opacity: 0, y: 20 }"
                :animate="{ opacity: 1, y: 0 }"
                :transition="{ duration: 1, delay: 0.6 }"
            >
                Sumber informasi terbaru tentang pemerintahan Desa Jabung
            </motion.p>
        </div>
    </motion.section>
</template>
