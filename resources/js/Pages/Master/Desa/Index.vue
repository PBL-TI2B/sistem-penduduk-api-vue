<script setup>
import { Head, router } from "@inertiajs/vue3";
import { ref, onMounted, watch } from "vue";
import { apiGet, apiDelete } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { SquarePlus, SearchIcon, X } from "lucide-vue-next";

import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import DataTable from "@/components/master/DataTable.vue";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import FormDialogDusun from "./components/FormDialogDusun.vue";
import FormDialogDesa from "./components/FormDialogDesa.vue";
import FormDialogRw from "./components/FormDialogRw.vue";
import FormDialogRt from "./components/FormDialogRt.vue";
import AlertDialog from "@/components/master/AlertDialog.vue";

import { columnsIndex, getActionsDesa } from "./utils/tableDesa";
import { columnsIndex2, getActionsDusun } from "./utils/tableDusun";
import { columnsIndex3, getActionsRw } from "./utils/tableRw";
import { columnsIndex4, getActionsRt } from "./utils/tableRt";

// ======================= DESA ========================
const items = ref([]);
const totalPages = ref(1);
const page = ref(1);
const perPage = ref(10);
const isLoading = ref(false);
const searchDesa = ref("");
const totalFirstData = ref(0);

// Dialog dan state hapus desa
const isFormDialogDesaOpen = ref(false);
const dialogModeDesa = ref("create");
const currentDesaData = ref(null);

const isAlertDeleteDesaOpen = ref(false);
const selectedDesaUuid = ref(null);

const fetchData = async () => {
    try {
        items.value = [];
        isLoading.value = true;
        const res = await apiGet("/desa", {
            page: page.value,
            search: searchDesa.value, // pakai searchDesa
        });
        items.value = res.data.data;
        perPage.value = res.data.per_page;
        totalPages.value = res.data.last_page;
        totalFirstData.value = res.data.total;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data desa");
    } finally {
        isLoading.value = false;
    }
};
watch(page, () => {
    fetchData();
});

const createDesa = () => {
    dialogModeDesa.value = "create";
    currentDesaData.value = null;
    isFormDialogDesaOpen.value = true;
};

const editDesa = (data) => {
    dialogModeDesa.value = "edit";
    currentDesaData.value = data;
    isFormDialogDesaOpen.value = true;
};

// Fungsi buka dialog konfirmasi hapus dusun
const onClickDeleteDesa = (uuid) => {
    selectedDesaUuid.value = uuid;
    isAlertDeleteDesaOpen.value = true;
};

// Konfirmasi hapus dusun
const onConfirmDeleteDesa = async () => {
    if (selectedDesaUuid.value) {
        try {
            await apiDelete(`/desa/${selectedDesaUuid.value}`);
            await fetchData();
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus desa");
        } finally {
            isAlertDeleteDesaOpen.value = false;
            selectedDesaUuid.value = null;
        }
    }
};

// Batal hapus dusun
const onCancelDeleteDesa = () => {
    isAlertDeleteDesaOpen.value = false;
    selectedDesaUuid.value = null;
};

// Update actions dengan fungsi hapus baru
const actionsIndex = getActionsDesa({
    onEdit: editDesa,
    onDelete: (item) => onClickDeleteDesa(item.uuid),
});

onMounted(fetchData);

// watch([page, fetchData]);
const onSearchEnterDesa = (e) => {
    if (e.key === "Enter") {
        page.value = 1;
        fetchData();
    }
};
const applyFilter = () => {
    page.value = 1;
    fetchData();
};

const clearSearchDesa = () => {
    searchDesa.value = "";
    applyFilter();
};

// ======================= DUSUN ========================
const items2 = ref([]);
const totalPages2 = ref(1);
const page2 = ref(1);
const perPage2 = ref(10);
const isLoading2 = ref(false);
const searchDusun = ref("");
const totalData = ref(0);

// Dialog dan state hapus dusun
const isFormDialogDusunOpen = ref(false);
const dialogModeDusun = ref("create");
const currentDusunData = ref(null);

const isAlertDeleteDusunOpen = ref(false);
const selectedDusunUuid = ref(null);

const fetchData2 = async () => {
    try {
        items2.value = [];
        isLoading2.value = true;
        const res = await apiGet("/dusun", {
            page: page2.value,
            search: searchDusun.value, // pakai searchDusun
        });
        items2.value = res.data.data;
        perPage2.value = res.data.per_page;
        totalPages2.value = res.data.last_page;
        totalData.value = res.data.total;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data dusun");
    } finally {
        isLoading2.value = false;
    }
};

onMounted(fetchData2);
watch(page2, () => {
    fetchData2();
});
const applyFilter2 = () => {
    page2.value = 1;
    fetchData2();
};

const clearSearchDusun = () => {
    searchDusun.value = "";
    applyFilter2();
};
// watch([page2, searchDusun], fetchData2);
const onSearchEnterDusun = (e) => {
    if (e.key === "Enter") {
        page2.value = 1;
        fetchData2();
    }
};

const createDusun = () => {
    dialogModeDusun.value = "create";
    currentDusunData.value = null;
    isFormDialogDusunOpen.value = true;
};

const editDusun = (data) => {
    dialogModeDusun.value = "edit";
    currentDusunData.value = data;
    isFormDialogDusunOpen.value = true;
};

// Fungsi buka dialog konfirmasi hapus dusun
const onClickDeleteDusun = (uuid) => {
    selectedDusunUuid.value = uuid;
    isAlertDeleteDusunOpen.value = true;
};

// Konfirmasi hapus dusun
const onConfirmDeleteDusun = async () => {
    if (selectedDusunUuid.value) {
        try {
            await apiDelete(`/dusun/${selectedDusunUuid.value}`);
            await fetchData2();
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus dusun");
        } finally {
            isAlertDeleteDusunOpen.value = false;
            selectedDusunUuid.value = null;
        }
    }
};

// Batal hapus dusun
const onCancelDeleteDusun = () => {
    isAlertDeleteDusunOpen.value = false;
    selectedDusunUuid.value = null;
};

// Update actions dengan fungsi hapus baru
const actionsIndex2 = getActionsDusun({
    onEdit: editDusun,
    onDelete: (item) => onClickDeleteDusun(item.uuid),
});

//======================== RW ========================

const items3 = ref([]);
const totalPages3 = ref(1);
const page3 = ref(1);
const perPage3 = ref(5);
const isLoading3 = ref(false);
const searchRw = ref("");
const totalRwData = ref(0);

// Dialog dan state hapus dusun
const isFormDialogRwOpen = ref(false);
const dialogModeRw = ref("create");
const currentRwData = ref(null);

const isAlertDeleteRwOpen = ref(false);
const selectedRwUuid = ref(null);

const fetchData3 = async () => {
    try {
        items3.value = [];
        isLoading3.value = true;
        const res = await apiGet("/rw", {
            page: page3.value,
            search: searchRw.value,
            per_page: perPage3.value, // pakai searchRw
        });
        items3.value = res.data.data;
        perPage3.value = res.data.per_page;
        totalPages3.value = res.data.last_page;
        totalRwData.value = res.data.total;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data rw");
    } finally {
        isLoading3.value = false;
    }
};
onMounted(fetchData3);
watch(page3, () => {
    fetchData3();
});
const applyFilter3 = () => {
    page3.value = 1;
    fetchData3();
};

const clearSearchRw = () => {
    searchRw.value = "";
    applyFilter3();
};
// watch([page2, searchDusun], fetchData2);
const onSearchEnterRw = (e) => {
    if (e.key === "Enter") {
        page3.value = 1;
        fetchData3();
    }
};

const createRw = () => {
    dialogModeRw.value = "create";
    currentRwData.value = null;
    isFormDialogRwOpen.value = true;
};

const editRw = (data) => {
    dialogModeRw.value = "edit";
    currentRwData.value = data;
    isFormDialogRwOpen.value = true;
};

// Fungsi buka dialog konfirmasi hapus dusun
const onClickDeleteRw = (uuid) => {
    selectedRwUuid.value = uuid;
    isAlertDeleteRwOpen.value = true;
};

// Konfirmasi hapus dusun
const onConfirmDeleteRw = async () => {
    if (selectedRwUuid.value) {
        try {
            await apiDelete(`/rw/${selectedRwUuid.value}`);
            await fetchData3();
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus rw");
        } finally {
            isAlertDeleteRwOpen.value = false;
            selectedRwUuid.value = null;
        }
    }
};

// Batal hapus dusun
const onCancelDeleteRw = () => {
    isAlertRwDusunOpen.value = false;
    selectedRwUuid.value = null;
};

const actionsIndex3 = getActionsRw({
    onEdit: editRw,
    onDelete: (item) => onClickDeleteRw(item.uuid), // Assuming you create onClickDeleteRw
});

//======================== RT ========================

const items4 = ref([]);
const totalPages4 = ref(1);
const page4 = ref(1);
const perPage4 = ref(5);
const isLoading4 = ref(false);
const searchRt = ref("");
const totalRtData = ref(0);

// Dialog dan state hapus dusun
const isFormDialogRtOpen = ref(false);
const dialogModeRt = ref("create");
const currentRtData = ref(null);

const isAlertDeleteRtOpen = ref(false);
const selectedRtUuid = ref(null);

const fetchData4 = async () => {
    try {
        items4.value = [];
        isLoading4.value = true;
        const res = await apiGet("/rt", {
            page: page4.value,
            search: searchRt.value,
            per_page: perPage4.value, // pakai searchRw
        });
        items4.value = res.data.data;
        perPage4.value = res.data.per_page;
        totalPages4.value = res.data.last_page;
        totalRtData.value = res.data.total;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data rt");
    } finally {
        isLoading4.value = false;
    }
};
onMounted(fetchData4);
watch(page4, () => {
    fetchData4();
});
const applyFilter4 = () => {
    page4.value = 1;
    fetchData4();
};

const clearSearchRt = () => {
    searchRt.value = "";
    applyFilter4();
};
// watch([page2, searchDusun], fetchData2);
const onSearchEnterRt = (e) => {
    if (e.key === "Enter") {
        page4.value = 1;
        fetchData4();
    }
};

const createRt = () => {
    dialogModeRt.value = "create";
    currentRtData.value = null;
    isFormDialogRtOpen.value = true;
};

const editRt = (data) => {
    dialogModeRt.value = "edit";
    currentRtData.value = data;
    isFormDialogRtOpen.value = true;
};

// Fungsi buka dialog konfirmasi hapus dusun
const onClickDeleteRt = (uuid) => {
    selectedRtUuid.value = uuid;
    isAlertDeleteRtOpen.value = true;
};

// Konfirmasi hapus dusun
const onConfirmDeleteRt = async () => {
    if (selectedRtUuid.value) {
        try {
            await apiDelete(`/rt/${selectedRtUuid.value}`);
            await fetchData4();
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus rt");
        } finally {
            isAlertDeleteRtOpen.value = false;
            selectedRtUuid.value = null;
        }
    }
};

// Batal hapus dusun
const onCancelDeleteRt = () => {
    isAlertRtOpen.value = false;
    selectedRtUuid.value = null;
};

const actionsIndex4 = getActionsRt({
    onEdit: editRt,
    onDelete: (item) => onClickDeleteRt(item.uuid), // Assuming you create onClickDeleteRw
});
</script>

<template>
    <Head title=" | Data Desa & Dusun" />
    <div class="flex items-center justify-between py-3">
        <div class="grid gap-1">
            <h1 class="text-3xl font-bold">Data Desa & Dusun</h1>
            <BreadcrumbComponent
                :items="[
                    { label: 'Dashboard', href: '/admin/dashboard' },
                    { label: 'Data Desa & Dusun' },
                ]"
            />
        </div>
    </div>

    <div class="drop-shadow-md w-full grid gap-2">
        <div class="flex xl:flex-row flex-col gap-4 items-center">
            <div
                class="flex bg-primary-foreground relative items-center p-2 rounded-lg gap-2 justify-between w-full"
            >
                <Input
                    v-model="searchDesa"
                    @keyup.enter="onSearchEnterDesa"
                    placeholder="Cari desa berdasarkan nama"
                    class="pl-10 pr-8"
                />
                <span
                    class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
                >
                    <SearchIcon class="size-6 text-muted-foreground" />
                </span>
                <button
                    v-if="searchDesa"
                    class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                    @click="clearSearchDesa"
                    tabindex="-1"
                    type="button"
                >
                    <X class="size-5" />
                </button>
                <!-- <button class="cursor-pointer">Terapkan</button> -->
            </div>
            <!-- <div
                class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between"
            >
                <Button @click="createDesa"><SquarePlus />Desa </Button>
            </div> -->
        </div>
        <!-- TABEL DESA -->
        <DataTable
            label="Desa"
            :items="items"
            :totalData="totalFirstData"
            :columns="columnsIndex"
            :actions="actionsIndex"
            :totalPages="totalPages"
            :page="page"
            :per-page="perPage"
            :is-loading="isLoading"
            @update:page="page = $event"
        />

        <FormDialogDesa
            v-model:isOpen="isFormDialogDesaOpen"
            :mode="dialogModeDesa"
            :initialData="currentDesaData"
            @success="fetchData"
        />

        <!-- TABEL DUSUN -->
        <div class="flex xl:flex-row flex-col gap-4 items-center">
            <div
                class="flex bg-primary-foreground relative items-center p-2 rounded-lg gap-2 justify-between w-full"
            >
                <Input
                    v-model="searchDusun"
                    @keyup.enter="onSearchEnterDusun"
                    placeholder="Cari dusun berdasarkan nama"
                    class="pl-10 pr-8"
                />
                <span
                    class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
                >
                    <SearchIcon class="size-6 text-muted-foreground" />
                </span>
                <button
                    v-if="searchDusun"
                    class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                    @click="clearSearchDusun"
                    tabindex="-1"
                    type="button"
                >
                    <X class="size-5" />
                </button>
                <!-- <Button class="cursor-pointer">Terapkan</Button> -->
            </div>
            <div
                class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between"
            >
                <Button @click="createDusun"><SquarePlus />Dusun </Button>
            </div>
        </div>
        <DataTable
            label="Dusun"
            :items="items2"
            :totalData="totalData"
            :columns="columnsIndex2"
            :actions="actionsIndex2"
            :totalPages="totalPages2"
            :page="page2"
            :per-page="perPage2"
            :is-loading="isLoading2"
            :is-exportable="true"
            @update:page="page2 = $event"
        />

        <FormDialogDusun
            v-model:isOpen="isFormDialogDusunOpen"
            :mode="dialogModeDusun"
            :initialData="currentDusunData"
            @success="fetchData2"
        />

        <div class="flex xl:flex-row flex-col gap-4 items-center">
            <div
                class="flex bg-primary-foreground relative items-center p-2 rounded-lg gap-2 justify-between w-full"
            >
                <Input
                    v-model="searchRw"
                    @keyup.enter="onSearchEnterRw"
                    placeholder="Cari rw berdasarkan nama"
                    class="pl-10 pr-8"
                />
                <span
                    class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
                >
                    <SearchIcon class="size-6 text-muted-foreground" />
                </span>
                <button
                    v-if="searchRw"
                    class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                    @click="clearSearchDusun"
                    tabindex="-1"
                    type="button"
                >
                    <X class="size-5" />
                </button>
                <!-- <Button class="cursor-pointer">Terapkan</Button> -->
            </div>
            <div
                class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between"
            >
                <Button @click="createRw"><SquarePlus />Rw </Button>
            </div>
        </div>
        <DataTable
            label="Rw"
            :items="items3"
            :totalData="totalRwData"
            :columns="columnsIndex3"
            :actions="actionsIndex3"
            :totalPages="totalPages3"
            :page="page3"
            :per-page="perPage3"
            :is-loading="isLoading3"
            :is-exportable="true"
            @update:page="page3 = $event"
        />

        <FormDialogRw
            v-model:isOpen="isFormDialogRwOpen"
            :mode="dialogModeRw"
            :initialData="currentRwData"
            @success="fetchData3"
        />
    </div>

    <div class="flex xl:flex-row flex-col gap-4 items-center">
        <div
            class="flex bg-primary-foreground relative items-center p-2 rounded-lg gap-2 justify-between w-full"
        >
            <Input
                v-model="searchRw"
                @keyup.enter="onSearchEnterRw"
                placeholder="Cari rt berdasarkan nama"
                class="pl-10 pr-8"
            />
            <span
                class="absolute start-2 inset-y-0 flex items-center justify-center px-2"
            >
                <SearchIcon class="size-6 text-muted-foreground" />
            </span>
            <button
                v-if="searchRw"
                class="absolute end-2 inset-y-0 flex items-center px-2 text-muted-foreground hover:text-primary"
                @click="clearSearchDusun"
                tabindex="-1"
                type="button"
            >
                <X class="size-5" />
            </button>
            <!-- <Button class="cursor-pointer">Terapkan</Button> -->
        </div>
        <div
            class="flex bg-primary-foreground p-2 rounded-lg gap-2 justify-between"
        >
            <Button @click="createRt"><SquarePlus />Rt </Button>
        </div>
    </div>
    <DataTable
        label="Rt"
        :items="items4"
        :totalData="totalRtData"
        :columns="columnsIndex4"
        :actions="actionsIndex4"
        :totalPages="totalPages4"
        :page="page4"
        :per-page="perPage4"
        :is-loading="isLoading4"
        :is-exportable="true"
        @update:page="page4 = $event"
    />

    <FormDialogRt
        v-model:isOpen="isFormDialogRtOpen"
        :mode="dialogModeRt"
        :initialData="currentRtData"
        @success="fetchData4"
    />

    <AlertDialog
        v-model:isOpen="isAlertDeleteDusunOpen"
        title="Hapus Dusun"
        description="Apakah Anda yakin ingin menghapus dusun ini?"
        :onConfirm="onConfirmDeleteDusun"
        :onCancel="onCancelDeleteDusun"
    />

    <AlertDialog
        v-model:isOpen="isAlertDeleteDesaOpen"
        title="Hapus Desa"
        description="Apakah Anda yakin ingin menghapus desa ini?"
        :onConfirm="onConfirmDeleteDesa"
        :onCancel="onCancelDeleteDesa"
    />

    <AlertDialog
        v-model:isOpen="isAlertDeleteRwOpen"
        title="Hapus Rw"
        description="Apakah Anda yakin ingin menghapus rw ini?"
        :onConfirm="onConfirmDeleteRw"
        :onCancel="onCancelDeleteRw"
    />

    <AlertDialog
        v-model:isOpen="isAlertDeleteRtOpen"
        title="Hapus Rt"
        description="Apakah Anda yakin ingin menghapus rt ini?"
        :onConfirm="onConfirmDeleteRt"
        :onCancel="onCancelDeleteRt"
    />
</template>
