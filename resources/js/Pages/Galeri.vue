<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import GaleriSection from "@/components/public/galeri/GaleriSection.vue";
import Pagination from "@/components/public/galeri/Pagination.vue";

defineOptions({
    layout: PublicLayout,
});
</script>

<template>
    <Head title=" - Galeri Desa" />
    <div class="bg-gray-50 min-h-screen px-6 md:px-48 py-8 pt-15">
        <div class="flex flex-col max-w-6xl mx-auto py-8">
            <h1 class="text-3xl font-bold text-[#E5A025] mt-6">GALERI DESA</h1>
        </div>
        <GaleriSection />
        <Pagination />
    </div>
</template>
