<script setup>
import { ref, onMounted } from "vue";
import { apiGet } from "@/utils/api";

const perangkatDesa = ref([]);
const isLoading = ref(true);

const fetchPerangkatDesa = async () => {
    try {
        const res = await apiGet("/perangkat-desa");
        perangkatDesa.value = res.data.data; // <-- ambil array data di dalam pagination
    } catch (error) {
        console.error("Gagal mengambil data perangkat desa:", error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(fetchPerangkatDesa);
</script>

<template>
    <section>
        <h2 class="text-2xl font-bold text-[#2FB586] mb-4 mt-12">
            PERANGKAT DESA
        </h2>

        <div v-if="isLoading" class="text-gray-500">
            Memuat data perangkat...
        </div>
        <div v-else-if="!hasData" class="text-gray-500">
            Belum ada data perangkat desa.
        </div>

        <div
            v-else
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8"
        >
            <div
                v-for="perangkat in perangkatDesa"
                :key="perangkat.id"
                class="bg-green-800 w-64 h-84 rounded-xl shadow-xl hover:drop-shadow-xl text-center overflow-hidden"
            >
                <img
                    :src="`/api/penduduk/foto/${
                        perangkat.foto || 'default.jpg'
                    }`"
                    class="w-64 h-64 object-cover"
                    alt="Foto Perangkat Desa"
                />

                <div class="py-4 px-2">
                    <div class="font-semibold text-white text-lg">
                        {{ perangkat.nama_lengkap || "Nama tidak tersedia." }}
                    </div>
                    <div class="text-sm text-white">
                        {{ perangkat.jabatan }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
