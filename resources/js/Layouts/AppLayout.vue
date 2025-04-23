<script setup>
import { Toaster } from "vue-sonner";
</script>

<template>
    <nav>
        <ul class="flex space-x-4">
            <li>
                <a href="#" class="text-blue-500 hover:underline">Home</a>
            </li>
            <li>
                <a href="#" class="text-blue-500 hover:underline">About</a>
            </li>
            <li>
                <a href="#" class="text-blue-500 hover:underline">Contact</a>
            </li>
        </ul>
    </nav>
    <slot />
    <Toaster position="top-right" />
</template>
