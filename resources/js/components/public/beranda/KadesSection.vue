<script setup>
import BouncingCircle from "@/components/BouncingCircle.vue";
import Button from "@/components/ui/button/Button.vue";
import { ListCheck, ScrollText } from "lucide-vue-next";
import { motion } from "motion-v";
import { ref } from "vue";

const missions = [
    "Mewujudkan tata kelola pemerintahan yang baik",
    "Meningkatkan pelayanan publik",
    "Meningkatkan kualitas SDM dan sumber daya manusia",
    "Meningkatkan ketahanan ekonomi",
    "Meningkatkan kualitas lingkungan hidup",
    "Meningkatkan fasilitas kesehatan masyarakat",
    "Meningkatkan perekonomian dan kesejahteraan masyarakat",
    "Memperkuat kerja sama dan sinergi",
];

const isTabActive = ref(true);
const toggleTab = (tab) => {
    isTabActive.value = tab === "sambutan";
};
</script>

<template>
    <section>
        <div
            class="flex gap-4 items-center justify-center w-full drop-shadow-md"
        >
            <div
                class="bg-primary-foreground text-gray-600 flex gap-2 rounded-full p-2"
            >
                <Button
                    type="button"
                    :variant="isTabActive ? 'frontend' : 'frontendOutline'"
                    class="text-sm md:text-base p-5 transition-colors duration-300 ease-in-out"
                    @click="toggleTab('sambutan')"
                >
                    <ScrollText />
                    Sambutan
                </Button>
                <Button
                    type="button"
                    :variant="!isTabActive ? 'frontend' : 'frontendOutline'"
                    class="text-sm md:text-base p-5 transition-colors duration-300 ease-in-out"
                    @click="toggleTab('visi-misi')"
                >
                    <ListCheck />
                    Visi Misi
                </Button>
            </div>
        </div>

        <motion.div
            v-if="isTabActive"
            class="bg-white drop-shadow-md hover:drop-shadow-xl mx-4 max-w-6xl lg:mx-auto my-8 rounded-xl px-6 py-4 lg:px-16 lg:py-10"
            :whileHover="{ scale: 1.02, transition: { duration: 0.2 } }"
            :initial="{ opacity: 0, y: 20 }"
            :animate="{ opacity: 1, y: 0 }"
            :exit="{ opacity: 0, y: 20 }"
            transition="{ duration: 0.6, ease: 'easeOut' }"
        >
            <div
                class="container mx-auto flex flex-col-reverse md:flex-row justify-between gap-4"
            >
                <!-- Teks Sambutan -->
                <div class="flex-1">
                    <!-- Menambahkan padding kiri -->

                    <h2
                        class="text-xl md:-text-3xl lg:text-4xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-emerald-500"
                    >
                        Sambutan Kepala Desa
                    </h2>
                    <div class="prose lg:prose-lg">
                        <p>Assalamualaikum Wr. Wb.</p>
                        <p>
                            Website ini hadir sebagai wujud transformasi desa
                            Jabung menjadi desa yang mampu memanfaatkan
                            teknologi informasi dan komunikasi, terintegrasi
                            kedalam sistem online. Keterbukaan informasi publik,
                            pelayanan publik, dan kegiatan perekonomian di desa
                            guna mewujudkan desa Jabung sebagai desa wisata
                            berkelanjutan, adaptasi dan mitigasi terhadap
                            perubahan iklim serta menjadi desa yang mandiri.
                        </p>
                        <p></p>
                        <p>
                            Mari bersama-sama kita bangun Desa Jabung yang lebih
                            baik, maju, dan sejahtera. Dengan kerjasama dan
                            gotong royong, tidak ada yang tidak mungkin untuk
                            kita wujudkan.
                        </p>
                        <p>Wassalamualaikum Wr. Wb.</p>
                    </div>
                </div>

                <!-- Foto Kepala Desa -->
                <div class="">
                    <img
                        src="@/images/kepala-desa.png"
                        alt="Kepala Desa"
                        class="w-60 h-60 rounded-full object-cover"
                    />
                    <p class="text-primary md:-text-xl lg:text-2xl font-bold">
                        Wisnu Sadewa
                    </p>
                    <p class="text-primary mb-4 text-lg">
                        Kepala Desa Jabung <br />
                        <span class="text-sm"> 2024 - 2029 </span>
                    </p>
                    <BouncingCircle />
                </div>
            </div>
        </motion.div>

        <div
            v-else
            class="mx-4 my-8 max-w-6xl lg:mx-auto rounded-xl flex flex-col md:flex-row gap-3 lg:gap-6"
        >
            <!-- Visi -->
            <motion.div
                class="bg-white drop-shadow-md hover:drop-shadow-xl rounded-xl flex-grow flex flex-col md:w-2/5 text-center md:px-16 md:py-10 px-6 py-4"
                :whileHover="{ scale: 1.02, transition: { duration: 0.2 } }"
                :initial="{ opacity: 0, y: 20 }"
                :animate="{ opacity: 1, y: 0 }"
                :exit="{ opacity: 0, y: 20 }"
                transition="{ duration: 0.6, ease: 'easeOut' }"
            >
                <h2 class="text-xl md:text-3xl font-bold text-border mb-4">
                    Visi
                </h2>
                <p class="text-gray-600 md:text-lg flex-grow">
                    Desa Jabung mampu menjadi desa yang berprestasi dan
                    mewujudkan masyarakat sejahtera.
                </p>
            </motion.div>

            <!-- Misi -->
            <motion.div
                class="bg-white drop-shadow-md hover:drop-shadow-xl rounded-xl flex-grow flex flex-col md:w-3/4 md:px-24 md:py-10 px-10 py-4"
                :whileHover="{ scale: 1.02, transition: { duration: 0.2 } }"
                :initial="{ opacity: 0, y: 20 }"
                :animate="{ opacity: 1, y: 0 }"
                :exit="{ opacity: 0, y: 20 }"
                transition="{ duration: 0.6, ease: 'easeOut' }"
            >
                <h2
                    class="text-xl md:text-3xl font-bold text-border mb-4 text-center"
                >
                    Misi
                </h2>
                <ol class="md:text-lg list-decimal list-outsite flex-grow">
                    <li
                        v-for="(mission, index) in missions"
                        :key="index"
                        class="text-gray-600"
                    >
                        {{ mission }}
                    </li>
                </ol>
            </motion.div>
        </div>
    </section>
</template>
