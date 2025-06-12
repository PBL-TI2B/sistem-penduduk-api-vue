<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import { apiGet } from "@/utils/api";
import { usePage } from "@inertiajs/vue3";

const uuid = window.location.pathname.split("/").pop();

const berita = ref(null);
const isLoading = ref(true);
const notFound = ref(false);

const formatTanggalWIB = (input) => {
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

const fetchDetailBerita = async () => {
    try {
        const res = await apiGet(`/berita/${uuid}`);
        const item = res.data.data;

        if (!item) {
            notFound.value = true;
            return;
        }

        berita.value = {
            title: item.judul,
            image: item.thumbnail
                ? `/storage/berita/${item.thumbnail}`
                : "/images/berita-lain.png",
            date: formatTanggalWIB(item.tanggal_post ?? item.created_at),
            views: item.jumlah_dilihat,
            content: item.konten,
            author: item.user?.name ?? "Admin",
        };
    } catch (error) {
        console.error("Gagal mengambil detail berita:", error);
        notFound.value = true;
    } finally {
        isLoading.value = false;
    }
};

onMounted(fetchDetailBerita);
</script>

<template>
    <div>
        <div v-if="isLoading">Memuat detail berita...</div>
        <div v-else-if="notFound">Berita tidak ditemukan.</div>
        <article v-else class="space-y-4">
            <h2 class="text-3xl font-bold">{{ berita.title }}</h2>
            <div class="text-sm text-gray-500">
                {{ berita.date }} &bull; {{ berita.views }}x dilihat
            </div>
            <img
                :src="berita.image"
                class="w-full rounded-lg shadow"
                alt="Gambar Berita"
            />
            <div
                class="text-justify text-base md:text-lg"
                v-html="berita.content"
            ></div>
        </article>
    </div>
</template>
