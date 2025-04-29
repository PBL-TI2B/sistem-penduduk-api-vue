<script setup>
import { Button } from "@/components/ui/button";
import PublicLayout from "@/Layouts/PublicLayout.vue";

defineOptions({
    layout: PublicLayout,
});
</script>

<template>
    <Head title=" | Home" />
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center">Welcome to the Home Page</h1>
        <p class="text-center">This is a simple Vue.js application.</p>
        <Button>Button</Button>
    </div>
</template>
