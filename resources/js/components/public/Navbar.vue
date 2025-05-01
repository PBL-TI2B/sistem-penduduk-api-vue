<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { usePage } from "@inertiajs/vue3";

const isOpen = ref(false);
const isScrolled = ref(false); // State for scroll detection

// State untuk halaman saat ini
const page = usePage();

// Fungsi untuk memeriksa apakah path aktif
const isActive = (path) => page.url.startsWith(path); // Gunakan startsWith untuk mencocokkan awal URL

// Fungsi untuk mendeteksi scroll
const handleScroll = () => {
    isScrolled.value = window.scrollY > 0;
};

// Tambahkan event listener saat komponen dimount
onMounted(() => {
    window.addEventListener("scroll", handleScroll);
    handleScroll(); // Inisialisasi state saat komponen dimuat
});

// Hapus event listener saat komponen dilepas
onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});
</script>

<template>
    <nav
        :class="[
            'fixed w-full text-white px-4 md:px-8 py-3 z-50 top-0 transition-colors duration-300',
            isScrolled || !isActive('/beranda') ? 'bg-[#0B391D]' : ''
        ]"
    >
        <div class="max-w-7xl md:px-auto flex flex-wrap justify-between items-center mx-auto">

            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <img src='@/images/logo.svg' alt="Logo Desa Jabung" class="h-8 md:h-14" />
                <div class="leading-tight">
                    <p class="text-sm md:text-2xl font-bold text-[#E5A025]">Desa Jabung</p>
                    <p class="text-xs md:text-xl text-white">Kabupaten Klaten</p>
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
            <div
                :class="[
                    'flex w-full md:w-auto mt-4 md:mt-0 justify-end space-x-4 font-medium text-sm md:text-xl',
                    isOpen ? '' : 'hidden md:block'
                ]"
            >
                <Link
                    href="/beranda"
                    :class="[
                        ' hover:text-[#F6C646]',
                        !isActive('/beranda')
                            ? 'text-white'
                            : 'text-[#F6C646]',
                    ]"
                >
                    Beranda
                </Link>
                <Link
                    href="/infografis"
                    :class="[
                        'hover:text-[#F6C646]',
                        !isActive('/infografis')
                            ? 'text-white'
                            : 'text-[#F6C646]',
                    ]"
                >
                    Infografis
                </Link>
                <Link
                    href="/berita"
                    :class="[
                        'hover:text-[#F6C646]',
                        !isActive('/berita')
                            ? 'text-white'
                            : 'text-[#F6C646]',
                    ]"
                >
                    Berita
                </Link>
                <Link
                    href="/galeri"
                    :class="[
                        'hover:text-[#F6C646]',
                        !isActive('/galeri')
                            ? 'text-white'
                            : 'text-[#F6C646]',
                    ]"
                >
                    Galeri
                </Link>
            </div>
        </div>
    </nav>
</template>
