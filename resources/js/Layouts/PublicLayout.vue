<script setup>
import Navbar from "@/components/public/Navbar.vue";
import Footer from "@/components/public/Footer.vue";
</script>

<template>
    <Navbar />
    <main class="grid gap-y-12 overflow-x-hidden">
        <slot />
    </main>
    <Footer />
</template>
