<script setup>
import Navbar from "@/components/public/Navbar.vue";
// import Footer from "@/components/public/Footer.vue";
// import { Toaster } from "vue-sonner";
</script>

<template>
    <Navbar />
    <main>
        <slot />
    </main>
    <Toaster position="top-right" />
</template>

<script>
export default {
    name: "LoginLayout",
};
</script>
