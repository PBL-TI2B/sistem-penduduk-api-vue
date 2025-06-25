<script setup lang="ts">
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { apiGet } from "@/utils/api";
import ToastViewer from "@/components/ToastViewer.vue";
import { Calendar, Eye, UserRoundCheck } from "lucide-vue-next";

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
</script>

<template>
    <section class="max-w-3xl mx-auto px-4 py-8">
        <div v-if="isLoading">
            <div class="col-span-2 bg-white overflow-hidden">
                <div class="w-full h-12 mb-12 bg-gray-300 rounded"></div>
                <div class="w-full h-52 bg-gray-200"></div>
                <div class="p-4 space-y-3">
                    <div class="w-full h-5 bg-gray-300 rounded"></div>
                    <div class="w-full h-4 bg-gray-200 rounded"></div>
                    <div class="w-1/2 h-4 bg-gray-200 rounded"></div>
                    <div class="w-1/2 h-4 bg-gray-200 rounded"></div>
                    <div class="w-1/2 h-4 bg-gray-200 rounded"></div>
                    <div class="w-full h-4 bg-gray-200 rounded"></div>
                    <div class="w-1/2 h-4 bg-gray-200 rounded"></div>
                    <div class="w-1/2 h-4 bg-gray-200 rounded"></div>
                    <div class="w-1/2 h-4 bg-gray-200 rounded"></div>
                </div>
            </div>
        </div>

        <div v-else-if="notFound" class="text-center text-gray-500">
            Berita tidak ditemukan.
        </div>

        <div v-else>
            <h1
                class="text-2xl md:text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-emerald-500 py-2 mb-2"
            >
                {{ berita.judul }}
            </h1>

            <img
                v-if="berita.thumbnail"
                :src="`/storage/berita/${berita.thumbnail}`"
                alt="Thumbnail Berita"
                class="rounded-xl w-full h-96 object-cover my-6"
                loading="lazy"
            />

            <div class="text-xs sm:text-sm flex flex-wrap gap-4">
                <div class="flex gap-2 items-center text-emerald-600">
                    <Calendar :size="15" />
                    {{ formatTanggalWIB(berita.created_at) }}
                </div>

                <div class="flex gap-2 items-center text-emerald-600">
                    <UserRoundCheck :size="15" />
                    {{ berita.user?.username || "Admin" }}
                </div>

                <div class="flex gap-2 items-center text-emerald-600">
                    <Eye :size="15" /> {{ berita.jumlah_dilihat }}x dilihat
                </div>
            </div>

            <ToastViewer :content="berita.konten" />
        </div>
    </section>
</template>
