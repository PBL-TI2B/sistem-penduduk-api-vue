<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import axios from "axios";
import { onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import Button from "@/components/ui/button/Button.vue";
import { SquarePen, Trash } from "lucide-vue-next";
import { route } from "ziggy-js";

const { uuid } = usePage().props;
const items = ref({});

const fetchData = async () => {
    const res = await axios.get(`/api/v1/penduduk/${uuid}`, {
        headers: {
            Authorization: `Bearer 12|JJcBEx2Ii6neCGacxa7AZ0JQAQbAmrq8RXnSdy31cb6fc1c9`,
        },
    });

    const result = res.data.data;
    items.value = result;
};

onMounted(fetchData);

const rows = [
    {
        label: "NIK",
        key: "nik",
    },
    {
        label: "Nama Lengkap",
        key: "nama_lengkap",
    },
    {
        label: "Jenis Kelamin",
        key: "jenis_kelamin",
        format: (value) => {
            return value === "L" ? "Laki-laki" : "Perempuan";
        },
    },
    {
        label: "Tempat Lahir",
        key: "tempat_lahir",
    },
    {
        label: "Tanggal Lahir",
        key: "tanggal_lahir",
    },
    {
        label: "Agama",
        key: "agama",
    },
    {
        label: "Gol. Darah",
        key: "gol_darah",
    },
    {
        label: "Status Perkawinan",
        key: "status_perkawinan",
    },
    {
        label: "Status",
        key: "status",
    },
    {
        label: "Tinggi Badan",
        key: "tinggi_badan",
    },
    {
        label: "Pekerjaan",
        key: "pekerjaan",
        format: (val, row) => row.pendidikan?.nama_pekerjaan || "-",
    },
    {
        label: "Pendidikan",
        key: "pendidikan",
        format: (val, row) => row.pendidikan?.jenjang || "-",
    },
    {
        label: "Ayah",
        key: "ayah",
        format: (val, row) => row.ayah?.nama_lengkap || "-",
    },
    {
        label: "Ibu",
        key: "ibu",
        format: (val, row) => row.ibu?.nama_lengkap || "-",
    },
];
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
        class="bg-primary-foreground p-2 rounded-lg flex gap-2 justify-between"
    >
        <div class="w-full">
            <table class="w-full gap-2 table">
                <tr
                    v-for="row in rows"
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
            :src="
                items.foto
                    ? '/api/v1/penduduk/foto/' + items.foto
                    : 'https://placehold.co/300x400?text=No+Photo'
            "
            alt="Profile Picture"
            class="rounded-md w-[300px] h-[400px] object-cover"
        />
    </div>
</template>
