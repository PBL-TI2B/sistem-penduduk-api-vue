<script setup>
import { computed } from "vue";
import { CalendarDays, Eye, MoveRight, User } from "lucide-vue-next";
import { motion } from "motion-v";
import Button from "@/components/ui/button/Button.vue";

const props = defineProps({
    news: Object,
    index: Number,
    isLarge: Boolean,
    isVerticalLayout: Boolean,
    hoverIndex: Number,
});

const emit = defineEmits(["hover"]);

const scaleValue = computed(() =>
    props.hoverIndex === props.index ? 1.05 : 1
);

const layoutType = computed(() => {
    if (props.isLarge) return "large";
    if (props.isVerticalLayout) return "vertical";
    return "horizontal";
});
</script>

<template>
    <motion.div
        @mouseenter="$emit('hover', index)"
        @mouseleave="$emit('hover', null)"
        :class="[
            'bg-white rounded-xl overflow-hidden',
            layoutType === 'large'
                ? 'lg:col-span-2 flex flex-col drop-shadow-sm hover:drop-shadow-lg hover:text-emerald-700 duration-200 text-left'
                : layoutType === 'vertical'
                ? 'flex flex-col drop-shadow-sm hover:drop-shadow-lg hover:text-emerald-700 duration-200 text-left'
                : 'flex gap-4 drop-shadow-sm hover:drop-shadow-lg hover:text-emerald-700',
        ]"
    >
        <div
            :class="[
                'relative overflow-hidden',
                layoutType === 'large'
                    ? 'w-full h-72 rounded-t-xl'
                    : layoutType === 'vertical'
                    ? 'w-full h-48 rounded-t-xl'
                    : 'w-52 h-auto rounded-l-xl',
            ]"
        >
            <motion.img
                :src="news.image"
                :alt="news.title"
                :animate="{ scale: scaleValue }"
                :transition="{ duration: 0.3 }"
                class="absolute w-full h-full inset-0 object-cover"
                loading="lazy"
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
                layoutType === 'large'
                    ? 'p-4'
                    : layoutType === 'vertical'
                    ? 'p-3'
                    : 'flex flex-col justify-between py-2 pr-4',
            ]"
        >
            <Link :href="`/berita/${news.slug}`">
                <h3
                    :class="[
                        'font-semibold',
                        layoutType === 'large'
                            ? 'text-2xl mb-2'
                            : layoutType === 'vertical'
                            ? 'text-lg mb-1'
                            : 'text-sm mb-1',
                    ]"
                >
                    {{ news.title.substring(0, 50) + "..." }}
                </h3>
            </Link>

            <div
                :class="[
                    'text-gray-500',
                    layoutType === 'large'
                        ? 'flex gap-8 text-sm mb-2'
                        : layoutType === 'vertical'
                        ? 'flex gap-6 text-xs mb-1'
                        : ' text-xs mb-1',
                ]"
            >
                <div class="flex items-center gap-1">
                    <CalendarDays
                        :size="layoutType === 'large' ? 16 : 12"
                        class="text-emerald-600"
                    />
                    <span>{{ news.date }}</span>
                </div>
                <div class="flex items-center gap-1">
                    <Eye
                        :size="layoutType === 'large' ? 16 : 12"
                        class="text-emerald-600"
                    />
                    <span>{{ news.views }} Kali Dilihat</span>
                </div>
            </div>

            <div
                :class="[
                    layoutType === 'large'
                        ? 'prose prose-sm text-gray-700 leading-relaxed'
                        : 'hidden',
                ]"
                v-html="news.excerpt"
            ></div>

            <div
                :class="[
                    'flex justify-between gap-4 items-center mt-2',
                    layoutType === 'large' ? '' : 'text-xs',
                ]"
            >
                <div class="flex items-center gap-1">
                    <User :size="16" class="text-emerald-600" />
                    <span
                        :class="
                            layoutType === 'large'
                                ? 'text-sm text-gray-500'
                                : 'text-xs text-gray-500'
                        "
                    >
                        {{ news.author }}
                    </span>
                </div>

                <Button
                    asChild
                    variant="frontendGhost"
                    :class="[
                        'flex items-center gap-2 group',
                        layoutType === 'large' ? '' : 'text-xs',
                    ]"
                >
                    <Link :href="`/berita/${news.slug}`">
                        {{
                            layoutType === "large"
                                ? "Baca Selengkapnya"
                                : "Selengkapnya"
                        }}
                        <MoveRight
                            class="transition-transform duration-300 group-hover:translate-x-1"
                        />
                    </Link>
                </Button>
            </div>
        </div>
    </motion.div>
</template>
