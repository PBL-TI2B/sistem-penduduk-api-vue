<script setup>
import Navbar from "@/components/public/Navbar.vue";
import Footer from "@/components/public/Footer.vue";
import { Toaster } from "vue-sonner";
</script>

<template>
    <Navbar />
    <slot />
    <Toaster position="top-right" />
    <Footer />
</template>
