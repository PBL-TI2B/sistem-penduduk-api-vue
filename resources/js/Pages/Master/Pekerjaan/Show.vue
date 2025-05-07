<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import Button from "@/components/ui/button/Button.vue";
import { SquarePen, Trash } from "lucide-vue-next";
import { rowsShow } from "./utils/table";
import { apiGet } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { onMounted, ref, onUnmounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import Cookies from "js-cookie";

const { uuid } = usePage().props;
const items = ref({});

const fetchData = async () => {
    try {
        const res = await apiGet(`/pekerjaan/${uuid}`);
        items.value = res.data;

    } catch (error) {
        useErrorHandler(error, "Gagal memuat detail pekerjaan");
    }
};

onMounted(fetchData);
</script>

<template>
    <Head title=" | Detail Pekerjaan" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Pekerjaan</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data Pekerjaan', href: '/pekerjaan' },
                    { label: 'Detail Pekerjaan' },
                ]"
            />
        </div>
        <div class="flex gap-4 items-center">
            <Button asChild>
                <Link :href="route('pekerjaan.edit', uuid)">
                    <SquarePen /> Ubah
                </Link>
            </Button>
            <Button variant="destructive"> <Trash /> Hapus </Button>
        </div>
    </div>

    <!-- Tampilkan hanya nama pekerjaan -->
    <div class="bg-primary-foreground p-4 rounded-lg">
        <h2 class="text-xl font-semibold">Nama Pekerjaan</h2>
        <p class="text-lg mt-2">{{ items.nama_pekerjaan }}</p>
    </div>
</template>
