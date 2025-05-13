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
            <h1 class="text-3xl font-bold text-[#E5A025] mt-6">PROFIL DESA</h1>
        </div>
        <DeskripsiSection />
        <VisiMisiSection />
        <PerangkatDesaSection />
        <SejarahDesaSection />
        <BatasWilayahSection />
        <PetaWilayahSection />
    </div>
</template>
