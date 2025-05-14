<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import { animate } from "motion-v";
import { Mars, ShieldUser, UsersRound, Venus } from "lucide-vue-next";

// Gunakan ref agar bisa diubah ketika data dari API masuk
const statistics = ref([
    { id: 1, name: "Penduduk", value: 0, icon: UsersRound },
    { id: 2, name: "Kepala Keluarga", value: 0, icon: ShieldUser },
    { id: 3, name: "Laki-laki", value: 0, icon: Mars },
    { id: 4, name: "Perempuan", value: 0, icon: Venus },
]);

const displayValues = ref(Array(statistics.value.length).fill(0));

onMounted(async () => {
    // Ambil data dari API
    try {
        const response = await axios.get(
            "http://127.0.0.1:8000/api/v1/statistik/demografi"
        );
        if (response.data.success) {
            const data = response.data.data;

            // Perbarui data statistik
            statistics.value = [
                {
                    id: 1,
                    name: "Penduduk",
                    value: data.total_penduduk,
                    icon: UsersRound,
                },
                {
                    id: 2,
                    name: "Kepala Keluarga",
                    value: data.jumlah_kepala_keluarga,
                    icon: ShieldUser,
                },
                {
                    id: 3,
                    name: "Laki-laki",
                    value: data.jumlah_laki_laki,
                    icon: Mars,
                },
                {
                    id: 4,
                    name: "Perempuan",
                    value: data.jumlah_perempuan,
                    icon: Venus,
                },
            ];

            // Reset tampilan angka animasi
            displayValues.value = Array(statistics.value.length).fill(0);
        }
    } catch (error) {
        console.error("Gagal mengambil data statistik:", error);
    }

    // Animasi scroll
    let hasAnimated = false;
    const isScrolled = window.scrollY > 0;

    const handleScroll = () => {
        if (hasAnimated) return;

        const element = document.getElementById("statistic-section");
        if (!element) return;

        const rect = element.getBoundingClientRect();
        const windowHeight =
            window.innerHeight || document.documentElement.clientHeight;

        if (rect.top <= windowHeight && rect.bottom >= 0) {
            hasAnimated = true;
            statistics.value.forEach((stat, index) => {
                animate(0, stat.value, {
                    duration: 2,
                    easing: "ease-out",
                    onUpdate: (latest) => {
                        displayValues.value[index] = Math.floor(latest);
                    },
                });
            });
        }
    };

    window.addEventListener("scroll", handleScroll);
    if (isScrolled) handleScroll(); // langsung animasi kalau sudah di scroll
});
</script>

<template>
    <div class="relative z-10 md:mx-5">
        <!-- screen medium -->
        <div
            class="text-white md:-mt-40 lg:-mt-60 flex md:px-6 py-6 max-w-6xl mx-auto md:px-auto md:justify-center items-center"
        >
            <div
                class="hidden md:block bg-center bg-no-repeat bg-contain drop-shadow-2xl"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="1000"
                    height="380"
                    viewBox="0 0 1372 473"
                    :class="'relative md:w-full'"
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
                        d="M1371.56 253.488C1371.56 395.4 722.356 472.494 379.876 472.494C37.3966 472.494 0.778076 331.098 0.778076 189.186C0.778076 47.2742 511.06 6.10352e-05 853.54 6.10352e-05C1196.02 6.10352e-05 1371.56 111.576 1371.56 253.488Z"
                    />
                </svg>
            </div>

            <div
                class="w-full md:w-auto md:absolute flex flex-col gap-4 md:gap-0 md:flex-row"
                id="statistic-section"
            >
                <div class="w-full md:hidden">
                    <h2
                        class="md:hidden w-1/2 mx-auto rounded-full p-2 bg-emerald-100 drop-shadow-md text-lg text-center text-emerald-800 font-semibold"
                    >
                        Statistik Desa
                    </h2>
                </div>
                <p class="md:hidden text-gray-600 text-center">
                    Data terbaru mengenai informasi geografis Desa Jabung
                </p>
                <template v-for="(stat, index) in statistics" :key="stat.id">
                    <template v-if="index > 0">
                        <div
                            class="hidden md:block border-l border-gray-100 h-16 sm:h-20 lg:h-40"
                        ></div>
                    </template>

                    <div
                        class="flex items-center justify-between md:text-center mx-4 md:mx-2 lg:mx-4 bg-gradient-to-br from-emerald-400 to-emerald-600 md:bg-none p-2 px-4 rounded-lg"
                    >
                        <div class="w-full">
                            <div
                                class="text-xl md:text-3xl lg:text-6xl font-bold"
                            >
                                {{
                                    displayValues[index].toLocaleString("id-ID")
                                }}
                            </div>
                            <div class="flex items-center gap-2">
                                <component
                                    :is="stat.icon"
                                    class="hidden md:block lg:hidden"
                                    size="16"
                                />
                                <component
                                    :is="stat.icon"
                                    class="hidden lg:block"
                                    size="25"
                                />
                                <div class="text-base lg:text-2xl">
                                    {{ stat.name }}
                                </div>
                            </div>
                        </div>
                        <component
                            :is="stat.icon"
                            class="block opacity-20 md:hidden"
                            size="50"
                        />
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>
