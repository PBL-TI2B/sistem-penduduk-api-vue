<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import { apiGet } from "@/utils/api";

const route = useRoute();
const berita = ref(null);
const isLoading = ref(true);
const notFound = ref(false);

const fetchDetailBerita = async () => {
    try {
        const id = route.params.id;
        const res = await apiGet(`/berita/${id}`);
        if (res.data && res.data.data) {
            berita.value = res.data.data;
        } else {
            notFound.value = true;
        }
    } catch (err) {
        console.error("Gagal mengambil detail berita:", err);
        notFound.value = true;
    } finally {
        isLoading.value = false;
    }
};

onMounted(fetchDetailBerita);
</script>

<template>
    <div>
        <div v-if="isLoading">Memuat berita...</div>
        <div v-else-if="notFound">Belum ada berita.</div>
        <article v-else class="lg:col-span-2 space-y-4">
            <h2 class="text-2xl font-semibold">{{ berita.judul }}</h2>
            <p class="text-sm text-gray-500">{{ berita.tanggal_post }}</p>
            <img
                :src="
                    berita.thumbnail
                        ? `/storage/${berita.thumbnail}`
                        : '/images/berita-lain.png'
                "
                class="w-full rounded-lg shadow"
                alt="Berita"
            />
            <div
                class="space-y-3 text-justify text-sm md:text-lg"
                v-html="berita.konten"
            ></div>
        </article>
    </div>
</template>
