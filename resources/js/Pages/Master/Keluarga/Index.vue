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
import { useKartuKeluarga } from "@/composables/useKartuKeluarga";
import { SquarePlus } from "lucide-vue-next";
import { route } from "ziggy-js";
import { columnsIndexKK } from "./utils/table";
import { actionsIndexKK } from "./utils/table";
import { onMounted } from "vue";

const {
    items,
    item,
    isLoading,
    page,
    perPage,
    totalPages,
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
} = useKartuKeluarga();

console.log(items);
onMounted(() => {
    fetchData();
});
</script>

<template>
    <Head title=" | Data Keluarga" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Keluarga</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Data Keluarga' },
                ]"
            />
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <Button asChild>
                <Link
                    :href="route('keluarga.create')"
                    class="flex items-center gap-1"
                >
                    <SquarePlus /> Keluarga
                </Link>
            </Button>
        </div>
    </div>
    <div class="drop-shadow-md w-full grid gap-2">
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between"
        >
            <Input
                placeholder="Cari keluarga (No. KK atau Kepala Keluarga)"
                class="md:w-1/3"
            />
            <!-- filter -->
            <div class="flex gap-4">
                <Select>
                    <SelectTrigger>
                        <SelectValue placeholder="Status Perkawinan" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Status Perkawinan</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem value="kawin"> Kawin </SelectItem>
                            <SelectItem value="belum kawin">
                                Belum Kawin
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select>
                    <SelectTrigger>
                        <SelectValue placeholder="No. RT" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>No. RT</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem value="001"> 001 </SelectItem>
                            <SelectItem value="002"> 002 </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Button class="cursor-pointer">Terapkan</Button>
            </div>
        </div>

        <DataTable
            label="Kartu Keluarga"
            :items="items"
            :columns="columnsIndexKK"
            :actions="actionsIndexKK"
            :totalPages="totalPages"
            :totalData="totalData"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            @update:page="page = $event"
        />
    </div>
</template>
