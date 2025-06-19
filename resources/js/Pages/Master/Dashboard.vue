<script setup>
import PendudukSection from "@/components/public/infografis/PendudukSection.vue";
import UmurSection from "@/components/public/infografis/UmurSection.vue";
import PendidikanSection from "@/components/public/infografis/PendidikanSection.vue";
import PekerjaanSection from "@/components/public/infografis/PekerjaanSection.vue";
import AgamaSection from "@/components/public/infografis/AgamaSection.vue";
import KelahiranKematianSection from "@/components/public/infografis/KelahiranKematianSection.vue";
</script>

<template>
    <PendudukSection />
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        <UmurSection />
        <AgamaSection />
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        <PendidikanSection />
        <PekerjaanSection />
    </div>
    <KelahiranKematianSection />
</template>
