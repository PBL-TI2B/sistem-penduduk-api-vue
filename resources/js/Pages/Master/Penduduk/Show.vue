<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import Button from "@/components/ui/button/Button.vue";
import { SquarePen, Trash } from "lucide-vue-next";
import { rowsShow } from "./table";
import { apiGet } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { onMounted, ref, onUnmounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import Cookies from "js-cookie";

const { uuid } = usePage().props;
const items = ref({});
const imageUrl = ref(null);

const fetchData = async () => {
    try {
        const res = await apiGet(`/penduduk/${uuid}`);
        items.value = res.data;
        console.log(items.value);

        if (items.value.foto) {
            const resImage = await axios.get(
                `/api/v1/penduduk/foto/${items.value.foto}`,
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
        useErrorHandler(error, "Gagal memuat detail penduduk");
    }
};

onMounted(fetchData);

onUnmounted(() => {
    if (imageUrl.value) {
        URL.revokeObjectURL(imageUrl.value);
    }
});
</script>

<template>
    <Head title=" | Detail Penduduk" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Penduduk</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data Penduduk', href: '/penduduk' },
                    { label: 'Detail Penduduk' },
                ]"
            />
        </div>
        <div class="flex gap-4 items-center">
            <Button asChild>
                <Link :href="route('penduduk.edit', uuid)">
                    <SquarePen /> Ubah
                </Link>
            </Button>
            <Button variant="destructive"> <Trash /> Hapus </Button>
        </div>
    </div>
    <div
        class="bg-primary-foreground p-2 rounded-lg flex flex-col sm:flex-row gap-2 justify-between"
    >
        <div class="w-full">
            <h2 class="text-lg font-bold p-2">
                Detail Data {{ items.nama_lengkap }}
            </h2>
            <table class="w-full gap-2 table">
                <tr
                    v-for="row in rowsShow.slice(0, -3)"
                    :key="row.key"
                    class="even:bg-card/30 p-2"
                >
                    <td class="font-medium p-2">
                        {{ row.label }}
                    </td>
                    <td>
                        {{
                            row.format
                                ? row.format(items[row.key], items)
                                : items[row.key]
                        }}
                    </td>
                </tr>
            </table>
        </div>
        <img
            v-if="imageUrl"
            :src="imageUrl"
            alt="Foto Penduduk"
            class="rounded-md w-[500px] h-[600px] object-cover"
        />
        <img
            v-else
            src="https://placehold.co/300x400?text=No+Photo"
            alt="No Photo"
            class="rounded-md w-[500px] h-[600px] object-cover"
        />
    </div>
    <div
        class="bg-primary-foreground p-2 rounded-lg flex gap-2 justify-between my-4"
    >
        <div class="w-1/2">
            <h2 class="text-lg font-bold p-2">Domisili Saat Ini</h2>
            <table class="w-full gap-2 table">
                <tr
                    v-for="row in rowsShow.slice(14)"
                    :key="row.key"
                    class="even:bg-card/30 p-2"
                >
                    <td class="font-medium p-2">
                        {{ row.label }}
                    </td>
                    <td>
                        {{
                            row.format
                                ? row.format(items[row.key], items)
                                : items[row.key]
                        }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>
