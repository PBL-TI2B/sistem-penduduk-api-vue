<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import { apiGet } from "@/utils/api";
import { usePage } from "@inertiajs/vue3";

const uuid = window.location.pathname.split("/").pop();

const isLoading = ref(true);
const berita = ref(null);

const formatTanggalWIB = (input: string): string => {
    const date = new Date(input);
    const utc = date.getTime() + date.getTimezoneOffset() * 60000;
    const wibTime = new Date(utc + 7 * 60 * 60000);
    const day = String(wibTime.getDate()).padStart(2, "0");
    const month = String(wibTime.getMonth() + 1).padStart(2, "0");
    const year = wibTime.getFullYear();
    const hours = String(wibTime.getHours()).padStart(2, "0");
    const minutes = String(wibTime.getMinutes()).padStart(2, "0");
    return `${day}/${month}/${year}, ${hours}.${minutes} WIB`;
};

const props = defineProps<{ slug: string }>();

const fetchDetailBerita = async () => {
    try {
        const res = await apiGet(`/berita/${props.slug}`);
        berita.value = res.data.data;
    } catch (error) {
        console.error("Gagal mengambil berita:", error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(fetchDetailBerita);
</script>

<template>
    <div class="max-w-4xl mx-auto px-4 py-6">
        <div v-if="isLoading">Memuat detail berita...</div>
        <div v-else-if="!berita">Berita tidak ditemukan.</div>
        <div v-else>
            <h1 class="text-3xl font-bold text-emerald-700 mb-2">
                {{ berita.judul }}
            </h1>
            <p class="text-sm text-gray-500 mb-4">
                Diposting
                {{ formatTanggalWIB(berita.tanggal_post ?? berita.created_at) }}
                • {{ berita.jumlah_dilihat }} Kali Dilihat
            </p>
            <img
                :src="
                    berita.thumbnail
                        ? `/storage/berita/${berita.thumbnail}`
                        : '/images/berita-lain.png'
                "
                class="rounded-xl mb-6 shadow"
                alt="Gambar Berita"
            />
            <div
                class="text-gray-700 text-justify leading-relaxed"
                v-html="berita.konten"
            ></div>
        </div>
    </div>
</template>
