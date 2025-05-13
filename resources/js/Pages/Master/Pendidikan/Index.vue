<script setup>
import { ref, onMounted, watch, h } from "vue";
import { apiGet } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { columnsIndex, actionsIndex } from "./utils/table";
import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import DataTable from "@/components/master/DataTable.vue";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import FormDialogPendidikan from "./FormDialogPendidikan.vue";

// State
const items = ref([]);
const totalPages = ref(1);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);
const isDialogOpen = ref(false);
const dialogMode = ref("create");
const selectedData = ref({});
const search = ref("");

// Fetch Data
const fetchData = async () => {
  try {
    isLoading.value = true;
    const res = await apiGet("/pendidikan", {
      page: page.value,
      search: search.value, // kalau API-nya support
    });
    items.value = res.data.data;
    perPage.value = res.data.per_page;
    totalPages.value = res.data.last_page;
  } catch (error) {
    useErrorHandler(error, "Gagal memuat data pendidikan");
  } finally {
    isLoading.value = false;
  }
};

// Dialog open
const openDialog = (mode, data = {}) => {
  dialogMode.value = mode;
  selectedData.value = data;
  isDialogOpen.value = true;
};

// Saat simpan data baru / edit
const handleSave = (formData) => {
  console.log("Data yang disimpan:", formData);
  isDialogOpen.value = false;
  fetchData();
};

// Saat klik Terapkan (search)
const applySearch = () => {
  page.value = 1; // reset ke page 1 kalau search
  fetchData();
};

// Lifecycle
onMounted(fetchData);
watch(page, fetchData);
</script>

<template>
  <Head title=" | Data Pendidikan" />

  <!-- Header -->
  <div class="flex items-center justify-between py-3">
    <div class="grid gap-1">
      <h1 class="text-3xl font-bold">Data Pendidikan</h1>
      <BreadcrumbComponent
        :items="[
          { label: 'Dashboard', href: '/' },
          { label: 'Data Pendidikan' },
        ]"
      />
    </div>
    <div class="flex flex-wrap gap-4 items-center">
      <Button @click="openDialog('create')">+ Pendidikan</Button>
    </div>
  </div>

  <!-- Filter -->
  <div class="drop-shadow-md w-full grid gap-2">
    <div
      class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between"
    >
      <Input
        v-model="search"
        placeholder="Cari pendidikan berdasarkan jenjang"
        class="md:w-1/3"
      />
      <Button class="cursor-pointer" @click="applySearch">Terapkan</Button>
    </div>

    <DataTable
        :items="items"
        :columns="columnsIndex"
        :actions="actionsIndex"
        :totalPages="totalPages"
        :page="page"
        :per-page="perPage"
        :is-loading="isLoading"
        @update:page="(val) => (page.value = val)"
    />
  </div>

  <!-- Dialog Pendidikan -->
  <FormDialogPendidikan
    :isOpen="isDialogOpen"
    :mode="dialogMode"
    :initialData="selectedData"
    @update:isOpen="(val) => (isDialogOpen.value = val)"
    @save="handleSave"
  />
</template>
