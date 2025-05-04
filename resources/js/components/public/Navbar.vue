<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { ChartArea, House, Images, Newspaper } from "lucide-vue-next";
import Button from "../ui/button/Button.vue";

const isOpen = ref(false);

const page = usePage();

const isActive = (path) => page.url.startsWith(path);

const menus = [
    { name: "Beranda", path: "/", icon: House },
    { name: "Infografis", path: "/infografis", icon: ChartArea },
    { name: "Berita", path: "/berita", icon: Newspaper },
    { name: "Galeri", path: "/galeri", icon: Images },
];
</script>

<template>
    <nav
        :class="[
            'fixed w-full text-gray-600 px-4 md:px-8 py-3 z-50 top-0 transition-colors drop-shadow-md duration-300 bg-primary-foreground',
        ]"
    >
        <div
            class="max-w-7xl md:px-auto flex flex-wrap justify-between items-center mx-auto"
        >
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <img
                    src="@/images/logo.svg"
                    alt="Logo Desa Jabung"
                    class="h-8 md:h-14"
                />
                <div class="leading-tight">
                    <p class="text-sm md:text-2xl font-bold text-emerald-500">
                        Desa Jabung
                    </p>
                    <p class="text-xs md:text-xl">Kabupaten Klaten</p>
                </div>
            </div>

            <!-- Hamburger (Mobile) -->
            <button
                @click="isOpen = !isOpen"
                class="md:hidden focus:outline-none"
            >
                <svg
                    class="h-6 w-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>
            </button>

            <!-- Menu -->
            <ul
                :class="[
                    'w-full md:w-auto mt-4 md:mt-0 items-center space-x-4 md:space-x-6 text-sm md:text-lg',
                    isOpen ? '' : 'hidden md:flex',
                ]"
            >
                <li v-for="menu in menus" :key="menu.path">
                    <Link
                        :href="menu.path"
                        :class="[
                            'flex items-center gap-1 hover:text-emerald-500 transition-colors',
                            !isActive(menu.path)
                                ? ''
                                : 'text-emerald-500 font-semibold',
                        ]"
                    >
                        <component :is="menu.icon" size="15" />
                        {{ menu.name }}
                    </Link>
                </li>
                <Button asChild variant="frontend">
                    <Link
                        href="/login"
                        class="text-primary-foreground bg-gradient-to-r from-secondary to-border py-2 px-12 rounded-full transition"
                    >
                        Masuk
                    </Link>
                </Button>
            </ul>
        </div>
    </nav>
</template>
