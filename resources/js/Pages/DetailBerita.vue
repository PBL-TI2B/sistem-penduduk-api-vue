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
    <div class="bg-gray-50 min-h-screen lg:px-12 py-8 pt-15">
        <div
            class="grid grid-cols-1 lg:grid-cols-3 gap-4 max-w-7xl mx-auto mt-4"
        >
            <!-- Konten utama -->
            <div class="lg:col-span-2">
                <BeritaUtamaSection />
            </div>

            <!-- Sidebar berita lainnya (dibungkus sticky di dalam) -->
            <div class="lg:col-span-1 px-4 sm:px-0">
                <div class="sticky top-24">
                    <BeritaLainnyaSection />
                </div>
            </div>
        </div>
    </div>
</template>
