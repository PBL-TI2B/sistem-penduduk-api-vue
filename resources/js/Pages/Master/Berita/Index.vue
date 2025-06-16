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
import dayjs from "dayjs";
import "dayjs/locale/id";
dayjs.locale("id");
// import {
//     Select,
//     SelectContent,
//     SelectGroup,
//     SelectItem,
//     SelectLabel,
//     SelectTrigger,
//     SelectValue,
// } from "@/components/ui/select";

const items = ref([]);
const totalPages = ref(1);
const totalData = ref(0);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);
const search = ref("");
const statusFilter = ref("");

const fetchData = async () => {
    try {
        items.value = [];
        isLoading.value = true;
        const res = await apiGet("/berita", {
            page: page.value,
            search: search.value,
            status: statusFilter.value,
        });
        items.value = res.data.data.map((item) => ({
            ...item,
            uuid: item.uuid ?? null,
            username: item.user_id?.username ?? "-",
            tanggal_post: item.created_at
                ? dayjs(item.created_at).format("dddd, DD MMMM YYYY HH:mm")
                : "-",
            terakhir_diubah: item.updated_at
                ? dayjs(item.updated_at).format("dddd, DD MMMM YYYY HH:mm")
                : "-",
        }));
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
        totalData.value = res.data.total;
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

const resetFilter = () => {
    statusFilter.value = "";
    applySearch();
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
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Berita' },
                ]"
            />
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <Button asChild>
                <Link :href="route('berita.create')">
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
            <Button
                asChild
                @click="
                    () => {
                        statusFilter = '';
                        applySearch();
                    }
                "
            >
                <div>
                    <FunnelX />
                    Reset
                </div>
            </Button>
        </div>
        <DataTable
            label="Berita"
            :totalData="totalData"
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
