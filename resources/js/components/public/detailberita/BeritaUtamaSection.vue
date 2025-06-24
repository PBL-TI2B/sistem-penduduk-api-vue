<script setup lang="ts">
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { apiGet } from "@/utils/api";

const berita = ref(null);
const isLoading = ref(true);
const notFound = ref(false);
const { slug } = usePage().props;

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

const fetchBeritaDetail = async () => {
    try {
        const res = await apiGet(`/berita/${slug}`);
        berita.value = res.data;
    } catch (error) {
        console.error("Berita tidak ditemukan:", error);
        notFound.value = true;
    } finally {
        isLoading.value = false;
    }
};

onMounted(fetchBeritaDetail);
console.log(berita);
</script>

<template>
    <section class="max-w-3xl mx-auto px-4 py-8">
        <div v-if="isLoading">Memuat data...</div>
        <div v-else-if="notFound" class="text-center text-gray-500">
            Berita tidak ditemukan.
        </div>

        <div v-else>
            <img
                v-if="berita.thumbnail"
                :src="`/storage/berita/${berita.thumbnail}`"
                alt="Thumbnail Berita"
                class="rounded-xl w-full h-64 object-cover mb-6"
            />

            <h1 class="text-2xl font-bold text-emerald-800 mb-2">
                {{ berita.judul }}
            </h1>

            <div class="text-sm text-gray-500 mb-6">
                <span
                    >Diterbitkan:
                    {{ formatTanggalWIB(berita.created_at) }}</span
                >
                · <span>Oleh: {{ berita.user.username }}</span> ·
                <span>{{ berita.jumlah_dilihat }}x dilihat</span>
            </div>

            <div
                class="prose prose-sm md:prose-base max-w-none text-justify"
                v-html="berita.konten"
            ></div>
        </div>
    </section>
</template>
