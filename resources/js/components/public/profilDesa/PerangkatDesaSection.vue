<script setup>
import { ref, onMounted } from "vue";
import { apiGet } from "@/utils/api";
import { computed } from "vue";

const hasData = computed(() => perangkatDesa.value.length > 0);
const perangkatDesa = ref([]);
const isLoading = ref(true);

const fetchPerangkatDesa = async () => {
    try {
        const res = await apiGet("/perangkat-desa");
        perangkatDesa.value = res.data.data;

        if (item.value.foto) {
            const resImage = await axios.get(
                `/api/v1/penduduk/foto/${item.value.foto}`,
                {
                    responseType: "blob",
                    headers: {
                        Authorization: `Bearer ${Cookies.get("token")}`,
                    },
                }
            );
            imageUrl.value = URL.createObjectURL(resImage.data);
        }
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
        <div
            class="flex items-center gap-2 bg-[#e7fcee] text-green-700 font-semibold px-4 py-2 rounded-full w-fit mt-8 mb-4"
        >
            <div class="w-1 h-6 bg-green-500 rounded"></div>
            <div
                class="flex items-center gap-2 md:text-xl font-bold text-[#233D34]"
            >
                <span>Perangkat Desa</span>
            </div>
        </div>
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
                    :src="
                        imageUrl
                            ? imageUrl
                            : 'https://placehold.co/300x400?text=No+Photo'
                    "
                    alt="Foto Perangkat Desa"
                    loading="lazy"
                    class="rounded-md w-[450px] h-[270px] object-cover"
                />

                <div class="py-2 px-2">
                    <div class="font-semibold text-white text-lg">
                        {{
                            perangkat.penduduk?.nama_lengkap ||
                            "Nama tidak tersedia."
                        }}
                    </div>
                    <div class="text-sm text-white">
                        {{
                            perangkat.jabatan?.jabatan ||
                            "Jabatan tidak tersedia."
                        }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
