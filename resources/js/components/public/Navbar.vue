<script setup>
import { onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { ChartArea, House, Images, Menu, Newspaper, X } from "lucide-vue-next";
import Button from "../ui/button/Button.vue";
import { onUnmounted } from "vue";
import { apiGet } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";

const isOpen = ref(false);
const isScrolled = ref(0);
const user = ref(null);

const fetchUserLoggedIn = async () => {
    try {
        const res = await apiGet("/auth/me");
        user.value = res.data;
        console.log(user.value);
    } catch (error) {
        useErrorHandler(error, "Unauthorized");
    }
};

const page = usePage();

const isActive = (path) => page.url.startsWith(path);
const isHomePath = page.url === "/";

const handleScroll = () => {
    isScrolled.value = window.scrollY > 0;
};

onMounted(() => fetchUserLoggedIn());

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
    handleScroll();
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});

console.log(isScrolled);

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
            'fixed w-full px-4 md:px-8 py-3 z-50 top-0 transition-colors duration-300',
            isHomePath ? 'text-white ' : 'bg-primary-foreground text-gray-600',
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
                <Menu
                    v-if="isOpen === false"
                    :class="isScrolled ? 'text-black' : 'text-white'"
                    :size="30"
                />
                <X
                    v-else
                    :class="isScrolled ? 'text-black' : 'text-white'"
                    :size="30"
                />
            </button>

            <!-- Menu -->
            <ul
                :class="[
                    'w-full md:w-auto mt-3 md:mt-0 items-center space-x-4 md:space-x-6 text-sm md:text-lg',
                    isOpen
                        ? 'grid gap-y-4 backdrop-blur-sm rounded-b-lg p-4'
                        : 'hidden md:flex',
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

                <Button v-if="user" asChild variant="frontend">
                    <Link
                        href="/dashboard"
                        class="text-primary-foreground bg-gradient-to-r from-secondary to-border py-2 px-12 rounded-full transition"
                    >
                        Dashboard
                    </Link>
                </Button>

                <Button v-else asChild variant="frontend">
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
