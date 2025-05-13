<script setup>
import { computed } from "vue";
import { CalendarDays, Eye, MoveRight, User } from "lucide-vue-next";
import { motion } from "motion-v";
import Button from "@/components/ui/button/Button.vue";

const props = defineProps({
    news: Object,
    index: Number,
    isLarge: Boolean,
    hoverIndex: Number,
});

const emit = defineEmits(["hover"]);

const scaleValue = computed(() =>
    props.hoverIndex === props.index ? 1.05 : 1
);
</script>

<template>
    <motion.div
        @mouseenter="$emit('hover', index)"
        @mouseleave="$emit('hover', null)"
        :class="[
            'bg-white rounded-xl overflow-hidden',
            isLarge
                ? 'lg:col-span-2 flex flex-col drop-shadow-sm hover:drop-shadow-lg hover:text-emerald-700 duration-200 text-left'
                : 'flex gap-4 drop-shadow-sm hover:drop-shadow-lg hover:text-emerald-700',
        ]"
    >
        <div
            :class="[
                'relative overflow-hidden',
                isLarge
                    ? 'w-full h-72 rounded-t-xl'
                    : 'w-52 h-auto rounded-l-xl',
            ]"
        >
            <motion.img
                :src="news.image"
                :alt="news.title"
                :animate="{ scale: scaleValue }"
                :transition="{ duration: 0.3 }"
                class="absolute w-full h-full inset-0 object-cover"
            />

            <motion.div
                class="absolute inset-0 bg-black/50"
                :animate="{
                    opacity: props.hoverIndex === props.index ? 0.4 : 0,
                }"
                :transition="{ duration: 0.3 }"
            />
        </div>

        <div
            :class="[
                isLarge ? 'p-4' : 'flex flex-col justify-between py-2 pr-4',
            ]"
        >
            <Link href="">
                <h3
                    :class="[
                        'font-semibold',
                        isLarge ? 'text-2xl mb-2' : 'text-sm mb-1',
                    ]"
                >
                    {{ news.title }}
                </h3>
            </Link>

            <div
                :class="[
                    'text-gray-500',
                    isLarge
                        ? 'flex gap-8 text-sm mb-2'
                        : 'flex gap-4 text-xs mb-1',
                ]"
            >
                <div class="flex items-center gap-1">
                    <CalendarDays
                        :size="isLarge ? 16 : 12"
                        class="text-emerald-600"
                    />
                    <span>{{ news.date }}</span>
                </div>
                <div class="flex items-center gap-1">
                    <Eye :size="isLarge ? 16 : 12" class="text-emerald-600" />
                    <span>{{ news.views }} Kali Dilihat</span>
                </div>
            </div>

            <p
                :class="[
                    isLarge
                        ? 'text-base text-gray-700 leading-relaxed'
                        : 'text-xs text-gray-700 line-clamp-2',
                ]"
            >
                {{ news.description }}
            </p>

            <div
                :class="[
                    'flex justify-between items-center mt-2',
                    isLarge ? '' : 'text-xs',
                ]"
            >
                <div class="flex items-center gap-1">
                    <User :size="16" class="text-emerald-600" />
                    <span
                        :class="isLarge ? 'text-sm' : 'text-xs text-gray-500'"
                    >
                        {{ news.author }}
                    </span>
                </div>

                <Button
                    asChild
                    variant="frontendGhost"
                    :class="[
                        'flex items-center gap-2 group',
                        isLarge ? '' : 'text-xs',
                    ]"
                >
                    <Link href="../../pages/berita">
                        {{ isLarge ? "Baca Selengkapnya" : "Selengkapnya" }}
                        <MoveRight
                            class="transition-transform duration-300 group-hover:translate-x-1"
                        />
                    </Link>
                </Button>
            </div>
        </div>
    </motion.div>
</template>
