<script setup>
import BeritaSection from "@/components/public/beranda/BeritaSection.vue";
import GaleriSection from "@/components/public/beranda/GaleriSection.vue";
import HeroSection from "@/components/public/beranda/HeroSection.vue";
import KadesSection from "@/components/public/beranda/KadesSection.vue";
import SejarahDesaSection from "@/components/public/beranda/SejarahDesaSection.vue";
import Statistik from "@/components/public/beranda/Statistik.vue";
import StrukturOrganisasiSection from "@/components/public/beranda/StrukturOrganisasiSection.vue";
import PublicLayout from "@/Layouts/PublicLayout.vue";
import { onMounted, onUnmounted, ref } from "vue";

defineOptions({
    layout: PublicLayout,
});

const isScrolled = ref(0);
const handleScroll = () => {
    isScrolled.value = window.scrollY > 0;
    if (isScrolled.value) {
        document.querySelector("nav").classList.add("bg-primary-foreground");
        document.querySelector("nav").classList.remove("text-white");
        document.querySelector("nav").classList.add("text-gray-600");
        document.querySelector("nav").classList.add("drop-shadow-md");
    } else {
        document.querySelector("nav").classList.remove("bg-primary-foreground");
        document.querySelector("nav").classList.add("text-white");
        document.querySelector("nav").classList.remove("text-gray-600");
        document.querySelector("nav").classList.remove("drop-shadow-md");
    }
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
    handleScroll();
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});
</script>

<template>
    <Head title=" - Beranda" />
    <HeroSection />
    <Statistik />
    <KadesSection />
    <!-- <StrukturOrganisasiSection /> -->
    <BeritaSection />
    <GaleriSection />
    <SejarahDesaSection />
</template>
