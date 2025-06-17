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
import {
    PenBoxIcon,
    SearchIcon,
    SquarePlus,
    Trash2,
    XIcon,
} from "lucide-vue-next";
import { route } from "ziggy-js";
import { onMounted, ref } from "vue";
import { columnsIndexUser } from "./utils/table";
import { actionsIndexUser } from "./utils/table";
import { useUser } from "@/composables/useUser";
import FormDialogUser from "./components/FormDialogUser.vue";
import AlertDialog from "@/components/master/AlertDialog.vue";

const isFormDialogOpen = ref(false);
const dialogMode = ref("create");
const selectedUser = ref(null);
const isAlertDeleteOpen = ref(false);
const selectedUuid = ref(null);

const {
    items,
    isLoading,
    page,
    perPage,
    totalPages,
    totalData,
    search,
    fetchData,
} = useUser();

const editUser = (user) => {
    isFormDialogOpen.value = true;
    dialogMode.value = "edit";
    selectedUser.value = user;
};

const createUser = () => {
    isFormDialogOpen.value = true;
    dialogMode.value = "create";
};

const actionsUser = [
    {
        label: "Ubah",
        icon: PenBoxIcon,
        handler: (item) => {
            editUser(item);
        },
    },
    {
        label: "Hapus",
        icon: Trash2,
        handler: (item) => {
            onClickDeleteButton(item.uuid);
        },
        // disabled: (item) => item,
    },
];

const onSearchEnter = (e) => {
    if (e.key === "Enter") {
        page.value = 1;
        fetchData();
    }
};

const clearSearchUser = () => {
    search.value = "";
    page.value = 1;
    fetchData();
};

const onClickDeleteButton = (uuid) => {
    selectedUuid.value = uuid;
    isAlertDeleteOpen.value = true;
};

const onCancelDelete = () => {
    isAlertDeleteOpen.value = false;
    selectedUuid.value = null;
};

const onConfirmDelete = async () => {
    if (selectedUuid.value) {
        await deleteJabatan(selectedUuid.value);
        isAlertDeleteOpen.value = false;
        selectedUuid.value = null;
    }
};

onMounted(() => {
    fetchData();
});
console.log(items);
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
            <Button @click="createUser"> <SquarePlus /> User </Button>
        </div>
    </div>
    <div class="drop-shadow-md w-full grid gap-2">
        <div
            class="bg-primary-foreground p-2 rounded-lg flex flex-wrap gap-2 justify-between"
        >
            <div class="flex flex-wrap gap-2 justify-between w-1/3">
                <div
                    class="flex bg-primary-foreground relative items-center p-2 rounded-lg justify-between w-full"
                >
                    <Input
                        v-model="search"
                        @keyup.enter="onSearchEnter"
                        placeholder="Cari data user berdasarkan username"
                        class="pl-10 pr-8"
                    />
                    <span
                        class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
                    >
                        <SearchIcon class="size-6 text-muted-foreground" />
                    </span>
                    <button
                        v-if="search"
                        @click="clearSearchUser"
                        class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                        title="Hapus pencarian"
                    >
                        <XIcon />
                    </button>
                </div>
            </div>
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
            :actions="actionsUser"
            :totalPages="totalPages"
            :totalData="totalData"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            @update:page="page = $event"
        />
    </div>
    <FormDialogUser
        v-model:isOpen="isFormDialogOpen"
        :mode="dialogMode"
        :initial-data="selectedUser"
        @success="fetchData"
    />
    <AlertDialog
        v-model:isOpen="isAlertDeleteOpen"
        title="Hapus User"
        description="Apakah anda yakin ingin menghapus user ini?"
        :onConfirm="onConfirmDelete"
        :onCancel="onCancelDelete"
    />
</template>
