<script setup>
import { ref } from "vue";
const props = defineProps({
    active: String,
});
const isOpen = ref(false);
</script>

<template>
    <nav
        :class="[
            'fixed top-0 w-full z-50 px-4 md:px-8 py-3 transition-colors duration-300',
            active !== 'beranda' ? 'bg-[#0B391D]' : '',
        ]"
    >
        <div class="max-w-7xl md:px-auto flex flex-wrap justify-between items-center mx-auto">

            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <img src='@/images/logo.svg' alt="Logo Desa Jabung" class="h-8 md:h-14" />
                <div class="leading-tight">
                    <p class="text-sm font-bold text-[#E5A025]">Desa Jabung</p>
                    <p class="text-xs text-white">Kabupaten Klaten</p>
                </div>
            </div>

            <!-- Hamburger (Mobile) -->
            <button @click="isOpen = !isOpen" class="md:hidden focus:outline-none">
                <svg
                    class="h-6 w-6 text-white"
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
            <button
                :class="[
                    'w-full flex justify-end md:items-center space-x-4 md:space-x-6 text-sm font-medium md:w-auto mt-4 md:mt-0',
                    isOpen ? '' : 'hidden md:block'
                ]"
            >
                <Link
                    href="../beranda"
                    :class="[
                        'text-white',
                        active === 'beranda'
                            ? 'text-[#F6C646]'
                            : 'hover:text-[#F6C646]',
                    ]"
                    >Beranda</Link
                >
                <Link
                    href="../infografis"
                    :class="[
                        'text-white',
                        active === 'infografis'
                            ? 'text-[#F6C646]'
                            : 'hover:text-[#F6C646]',
                    ]"
                    >Infografis</Link
                >
                <Link
                    href="../berita"
                    :class="[
                        'text-white',
                        active === 'berita'
                            ? 'text-[#F6C646]'
                            : 'hover:text-[#F6C646]',
                    ]"
                    >Berita</Link
                >
                <Link
                    href="../galeri"
                    :class="[
                        'text-white',
                        active === 'galeri'
                            ? 'text-[#F6C646]'
                            : 'hover:text-[#F6C646]',
                ]"
                >Galeri</Link
                >
            </button>
        </div>

    </nav>
</template>
