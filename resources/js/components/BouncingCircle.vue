<script setup>
import { motion } from "motion-v";

const circles = Array.from({ length: 5 });
</script>

<template>
    <div class="h-20 flex justify-start items-start gap-2">
        <template v-for="(_, index) in circles" :key="index">
            <motion.div
                class="w-2 h-2 bg-emerald-500 rounded-full"
                :initial="{ y: 0 }"
                :animate="{ y: [0, -2.5, 0] }"
                :transition="{
                    duration: 1.5,
                    repeat: Infinity,
                    repeatType: 'loop',
                    ease: 'easeInOut',
                    delay: index * 0.2, // Delay bertahap per circle
                }"
            />
        </template>
    </div>
</template>
