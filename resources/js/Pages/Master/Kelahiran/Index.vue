<script setup>
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import DataTable from "@/components/master/DataTable.vue";
import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import Select from "@/components/ui/select/Select.vue";
import SelectContent from "@/components/ui/select/SelectContent.vue";
import SelectGroup from "@/components/ui/select/SelectGroup.vue";
import SelectItem from "@/components/ui/select/SelectItem.vue";
import SelectLabel from "@/components/ui/select/SelectLabel.vue";
import SelectTrigger from "@/components/ui/select/SelectTrigger.vue";
import SelectValue from "@/components/ui/select/SelectValue.vue";
import { SearchIcon, SquarePlus, XIcon } from "lucide-vue-next";
import { route } from "ziggy-js";
import { onMounted, ref } from "vue";
import { useKelahiran } from "@/composables/useKelahiran";
import { columnsIndexKelahiran } from "./utils/table";
import { actionsIndexKelahiran } from "./utils/table";

const {
    items,
    item,
    isLoading,
    page,
    perPage,
    totalPages,
    filter,
    totalItems,
    totalData,
    search,
    selectedStatusValidasi,
    statusValidasiOptions,
    fetchData,
    fetchDetailData,
    createData,
    editData,
    deleteData,
} = useKelahiran();

const searchPenduduk = ref("");

const onSearchEnter = (e) => {
    if (e.key === "Enter") {
        page.value = 1;
        fetchData();
    }
};

const clearSearchPenduduk = () => {
    searchPenduduk.value = "";
    page.value = 1;
    fetchData();
};

const resetFilter = () => {
    filter.value = {
        waktu_kelahiran: "",
    };
    fetchData();
};

onMounted(() => {
    fetchData();
});
</script>

<template>
    <Head title=" | Data Kelahiran" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Kelahiran</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/' },
                    { label: 'Data Kelahiran' },
                ]"
            />
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <Button asChild>
                <Link
                    :href="route('user.create')"
                    class="flex items-center gap-1"
                >
                    <SquarePlus /> Kelahiran
                </Link>
            </Button>
        </div>
    </div>
    <div class="drop-shadow-md w-full grid gap-2">
        <div class="flex flex-wrap gap-2 justify-between">
            <div
                class="flex bg-primary-foreground relative items-center p-2 rounded-lg justify-between w-full"
            >
                <Input
                    v-model="searchPenduduk"
                    @keyup.enter="onSearchEnter"
                    placeholder="Cari data Penduduk"
                    class="pl-10 pr-8"
                />
                <span
                    class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
                >
                    <SearchIcon class="size-6 text-muted-foreground" />
                </span>
                <button
                    v-if="searchPenduduk"
                    @click="clearSearchPenduduk"
                    class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                    title="Hapus pencarian"
                >
                    <XIcon />
                </button>
            </div>
        </div>

        <DataTable
            label="Kelahiran"
            :items="items"
            :columns="columnsIndexKelahiran"
            :actions="actionsIndexKelahiran"
            :totalPages="totalPages"
            :totalData="totalData"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            @update:page="page = $event"
        />
    </div>
</template>
