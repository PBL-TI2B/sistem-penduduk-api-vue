<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import BeritaUtamaSection from "@/components/public/detailberita/BeritaUtamaSection.vue";
import BeritaLainnyaSection from "@/components/public/detailberita/BeritaLainnyaSection.vue";

defineOptions({
    layout: PublicLayout,
});
</script>

<template>
    <Head title=" - Berita Desa" />
    <div class="bg-gray-50 min-h-screen px-6 md:px-48 py-8 pt-24">
        <div
            class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6 max-w-7xl mx-auto mt-4"
        >
            <BeritaUtamaSection />
            <BeritaLainnyaSection />
        </div>
    </div>
</template>
