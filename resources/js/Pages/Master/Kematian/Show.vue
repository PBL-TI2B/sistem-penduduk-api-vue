<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import Button from "@/components/ui/button/Button.vue";
import { SquarePen, Trash } from "lucide-vue-next";
import { apiGet } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";

const { uuid } = usePage().props;
const items = ref({});

const fetchData = async () => {
    try {
        const res = await apiGet(`/kematian/${uuid}`);
        items.value = res.data;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat detail kematian");
    }
};

onMounted(fetchData);
</script>

<template>
    <Head title=" | Detail Kematian" />
    <div class="flex items-center justify-between py-3">
        <div>
            <h1 class="text-3xl font-bold">Detail Kematian</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Data Kematian', href: '/admin/kematian' },
                    { label: 'Detail' },
                ]"
            />
        </div>
        <div class="flex gap-4">
            <Button asChild>
                <Link :href="route('kematian.edit', uuid)">
                    <SquarePen /> Ubah
                </Link>
            </Button>
            <Button variant="destructive"> <Trash /> Hapus </Button>
        </div>
    </div>

    <div class="bg-primary-foreground p-4 rounded-lg space-y-2">
        <p><strong>Tanggal Kematian:</strong> {{ items.tanggal_kematian }}</p>
        <p><strong>Sebab Kematian:</strong> {{ items.sebab_kematian }}</p>
        <p>
            <strong>Nama Penduduk:</strong>
            {{ items.penduduk?.nama_lengkap || "-" }}
        </p>
    </div>
</template>
