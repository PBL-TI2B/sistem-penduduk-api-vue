<script setup>
import { route } from "ziggy-js";
import { ref, onMounted, watch } from "vue";
import { apiGet } from "@/utils/api";
import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import DataTable from "@/components/master/DataTable.vue";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { actionsIndex, columnsIndex } from "./utils/table";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { SquarePlus } from "lucide-vue-next";

const items = ref([]);
const totalPages = ref(1);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);
const search = ref("");

const fetchData = async () => {
    try {
        items.value = [];
        isLoading.value = true;
        const res = await apiGet("/berita", {
            page: page.value,
            search: search.value,
        });
        items.value = res.data.data.map((item) => ({
            ...item,
            uuid: item.uuid ?? null,
            username: item.user?.username ?? "-",
        }));
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data berita");
    } finally {
        isLoading.value = false;
    }
};

const applySearch = () => {
    page.value = 1;
    fetchData();
};

onMounted(fetchData);
watch(page, fetchData);
</script>

<template>
    <Head title=" | Berita" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Berita</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Berita' },
                ]"
            />
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <Button asChild>
                <Link :href="route('berita-admin.create')">
                    <SquarePlus /> Tambah Berita
                </Link>
            </Button>
        </div>
    </div>
    <div class="drop-shadow-md w-full grid gap-2">
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between"
        >
            <Input
                v-model="search"
                @keyup.enter="applySearch"
                placeholder="Cari berita berdasarkan judul"
                class="md:w-1/3"
            />
            <Button class="cursor-pointer">Terapkan</Button>
        </div>
        <DataTable
            label="Berita"
            :items="items"
            :columns="columnsIndex"
            :actions="actionsIndex"
            :totalPages="totalPages"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            @update:page="page = $event"
        />
    </div>
</template>
