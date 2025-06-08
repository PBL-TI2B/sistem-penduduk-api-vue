<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import {
    Blinds,
    ChartArea,
    House,
    Images,
    Menu,
    Newspaper,
    Store,
    X,
} from "lucide-vue-next";
import Button from "../ui/button/Button.vue";
import { apiGet } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";

const isOpen = ref(false);
const isScrolled = ref(false);
const user = ref(null);

const fetchUserLoggedIn = async () => {
    try {
        const res = await apiGet("/auth/me");
        user.value = res.data;
    } catch (error) {
        useErrorHandler(error, "Unauthorized");
    }
};

const handleScroll = () => {
    isScrolled.value = window.scrollY > 0;
};

onMounted(() => {
    fetchUserLoggedIn();
    window.addEventListener("scroll", handleScroll);
    handleScroll();
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});

const page = usePage();
const isHomePath = computed(() => page.url === "/");

const isActive = (path) => {
    if (path === "") return page.url === "/";
    return page.url.startsWith("/" + path);
};

const menus = [
    { name: "Beranda", path: "", icon: House },
    { name: "Profil Desa", path: "profildesa", icon: Blinds },
    { name: "Infografis", path: "infografis", icon: ChartArea },
    { name: "Berita", path: "berita", icon: Newspaper },
    { name: "Galeri", path: "galeri", icon: Images },
    // { name: "UMKM", path: "umkm", icon: Store },
];
</script>

<template>
    <nav
        :class="[
            'fixed w-full px-4 md:px-8 py-3 top-0 z-50 transition-all duration-300',
            isHomePath ? 'text-white' : 'text-gray-600 bg-white',
            isScrolled && !isHomePath ? 'shadow-md' : '',
        ]"
    >
        <div
            class="max-w-7xl flex flex-wrap justify-between items-center mx-auto"
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

            <!-- Hamburger Button -->
            <button
                @click="isOpen = !isOpen"
                class="md:hidden focus:outline-none"
            >
                <component
                    :is="isOpen ? X : Menu"
                    :class="
                        isScrolled || !isHomePath ? 'text-black' : 'text-white'
                    "
                    :size="30"
                />
            </button>

            <!-- Menu Items -->
            <ul
                :class="[
                    'w-full md:w-auto mt-3 md:mt-0 items-center text-sm md:text-lg',
                    isOpen
                        ? 'grid gap-y-4 p-4 backdrop-blur-sm rounded-b-lg'
                        : 'hidden md:flex space-x-4 md:space-x-6',
                ]"
            >
                <li v-for="menu in menus" :key="menu.path">
                    <Link
                        :href="'/' + menu.path"
                        @click="isOpen = false"
                        :class="[
                            'flex items-center gap-1 hover:text-emerald-500 transition-colors',
                            isActive(menu.path)
                                ? 'text-emerald-500 font-semibold'
                                : '',
                        ]"
                    >
                        <component :is="menu.icon" size="15" />
                        {{ menu.name }}
                    </Link>
                </li>

                <Button v-if="user" asChild variant="frontend">
                    <Link
                        href="/admin/dashboard"
                        class="py-2 px-12 rounded-full transition"
                        @click="isOpen = false"
                    >
                        Dashboard
                    </Link>
                </Button>

                <Button v-else asChild variant="frontend">
                    <Link
                        href="/login"
                        class="py-2 px-12 rounded-full transition"
                        @click="isOpen = false"
                    >
                        Masuk
                    </Link>
                </Button>
            </ul>
        </div>
    </nav>
</template>
