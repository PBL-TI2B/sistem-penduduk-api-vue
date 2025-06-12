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
import { SquarePlus } from "lucide-vue-next";
import { route } from "ziggy-js";
import { onMounted } from "vue";
import { columnsIndexUser } from "./utils/table";
import { actionsIndexUser } from "./utils/table";
import { useUser } from "@/composables/useUser";

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
} = useUser();

console.log(items);
onMounted(() => {
    fetchData();
});
</script>

<template>
    <Head title=" | Data User" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data User</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Data User' },
                ]"
            />
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <Button asChild>
                <Link
                    :href="route('user.create')"
                    class="flex items-center gap-1"
                >
                    <SquarePlus /> User
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
                        <SelectValue placeholder="Filter Role" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Role</SelectLabel>
                            <SelectItem value="-"> Semua </SelectItem>
                            <SelectItem value="superadmin">
                                Superadmin
                            </SelectItem>
                            <SelectItem value="admin"> Admin </SelectItem>
                            <SelectItem value="ketua rt"> Ketua RT </SelectItem>
                            <SelectItem value="ketua rw"> Ketua RW </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Button class="cursor-pointer">Terapkan</Button>
            </div>
        </div>

        <DataTable
            label="User"
            :items="items"
            :columns="columnsIndexUser"
            :actions="actionsIndexUser"
            :totalPages="totalPages"
            :totalData="totalData"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            @update:page="page = $event"
        />
    </div>
</template>
