<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import DeskripsiSection from "@/components/public/profilDesa/DeskripsiSection.vue";
import VisiMisiSection from "@/components/public/profilDesa/VisiMisiSection.vue";
import PerangkatDesaSection from "@/components/public/profilDesa/PerangkatDesaSection.vue";
import SejarahDesaSection from "@/components/public/profilDesa/SejarahDesaSection.vue";
import BatasWilayahSection from "@/components/public/profilDesa/BatasWilayahSection.vue";
import PetaWilayahSection from "@/components/public/profilDesa/PetaWilayahSection.vue";

defineOptions({
    layout: PublicLayout,
});
</script>

<template>
    <Head title=" - Profil Desa" />
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
                class="relative z-10 max-w-5xl mx-auto px-6 pt-15 mb-40 text-center text-white"
            >
                <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow">
                    PROFIL DESA
                </h1>
            </div>
        </div>
        <DeskripsiSection />
        <VisiMisiSection />
        <PerangkatDesaSection />
        <SejarahDesaSection />
        <BatasWilayahSection />
        <PetaWilayahSection />
    </div>
</template>
