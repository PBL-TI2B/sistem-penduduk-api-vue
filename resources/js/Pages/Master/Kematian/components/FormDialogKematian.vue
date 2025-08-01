<script setup>
import { computed, onMounted, ref, watch } from "vue";
import { useForm, useField } from "vee-validate";
import Button from "@/components/ui/button/Button.vue";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
import Label from "@/components/ui/label/Label.vue";
import Input from "@/components/ui/input/Input.vue";
import { useKematian } from "@/composables/useKematian";
import Select from "@/components/ui/select/Select.vue";
import SelectTrigger from "@/components/ui/select/SelectTrigger.vue";
import SelectValue from "@/components/ui/select/SelectValue.vue";
import SelectContent from "@/components/ui/select/SelectContent.vue";
import SelectItem from "@/components/ui/select/SelectItem.vue";
import { apiGet } from "@/utils/api";
import { debounce } from "lodash";

import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const props = defineProps({
    isOpen: Boolean,
    mode: {
        type: String,
        default: "create",
    },
    initialData: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(["update:isOpen", "success"]);
const penduduk = ref([]);
const search = ref(""); // //
const pendudukOptions = ref([]); // //
const loadingPenduduk = ref(false); // //

// Perbaikan: Tambahkan default values yang lebih eksplisit
const defaultValues = {
    penduduk_id: "",
    tanggal_kematian: "",
    sebab_kematian: "",
};

const { handleSubmit, resetForm, setValues, values, errors } = useForm();

// Perbaikan: Gunakan useField untuk setiap field
const { value: penduduk_id, errorMessage: pendudukIdError } =
    useField("penduduk_id");
const { value: tanggal_kematian, errorMessage: tanggalKematianError } =
    useField("tanggal_kematian");
const { value: sebab_kematian, errorMessage: sebabKematianError } =
    useField("sebab_kematian");

const { createAndEditKematian } = useKematian();

const onSubmit = handleSubmit(async (formValues) => {
    try {
        // Pastikan semua field memiliki nilai
        const validatedValues = {
            penduduk_id: formValues.penduduk_id || "",
            tanggal_kematian: formValues.tanggal_kematian || "",
            sebab_kematian: formValues.sebab_kematian || "",
        };
        const rawTanggal = validatedValues.tanggal_kematian;
        const dateObj = new Date(rawTanggal);

        const formattedDate = dateObj
            .toISOString()
            .slice(0, 19)
            .replace("T", " ");
        validatedValues.tanggal_kematian = formattedDate;
        await createAndEditKematian(validatedValues, props, emit);
    } catch (error) {
        console.error("Form submission error:", error);
    }
});

watch(
    search,
    debounce(async (val) => {
        if (val.length < 2) {
            pendudukOptions.value = [];
            return;
        }
        loadingPenduduk.value = true;
        try {
            const res = await apiGet(`/penduduk?search=${val}&status=hidup`);
            pendudukOptions.value = res.data.data.map((p) => ({
                value: p.id,
                label: p.nama_lengkap,
            }));
        } catch (error) {
            pendudukOptions.value = [];
        }
        loadingPenduduk.value = false;
    }, 500)
);

const selectPenduduk = (option) => {
    penduduk_id.value = option.value;
    search.value = option.label;
    pendudukOptions.value = [];
};

onMounted(async () => {
    try {
        const res = await apiGet("/penduduk?status=hidup");
        penduduk.value = res.data.data.map((item) => ({
            value: item.id,
            label: item.nama_lengkap,
        }));
    } catch (error) {
        console.error("Error fetching penduduk:", error);
        penduduk.value = [];
    }
});

watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen && props.mode === "edit" && props.initialData) {
            // Perbaikan: Set nilai individual field
            penduduk_id.value = props.initialData.penduduk_id || "";
            search.value = props.initialData.penduduk_nama || "";
            tanggal_kematian.value = props.initialData.tanggal_kematian || "";
            sebab_kematian.value = props.initialData.sebab_kematian || "";
        } else if (isOpen && props.mode === "create") {
            penduduk_id.value = "";
            search.value = "";
            tanggal_kematian.value = "";
            sebab_kematian.value = "";
        } else if (!isOpen) {
            resetForm();
        }
    },
    { immediate: true }
);

const dialogTitle = computed(() =>
    props.mode === "create" ? "Tambah Kematian" : "Edit Kematian"
);
</script>

<template>
    <Dialog :open="props.isOpen" @update:open="emit('update:isOpen', $event)">
        <DialogContent class="sm:max-w-[425px]">
            <form @submit.prevent="onSubmit">
                <DialogHeader>
                    <DialogTitle>{{ dialogTitle }}</DialogTitle>
                    <DialogDescription>
                        {{
                            mode === "edit"
                                ? "Ubah data kematian"
                                : "Tambahkan data kematian baru"
                        }}
                    </DialogDescription>
                </DialogHeader>

                <div class="grid gap-4 py-4">
                    <div
                        class="w-full autocomplete-wrapper"
                        style="position: relative"
                    >
                        <Label
                            for="penduduk_id"
                            class="text-right"
                            :hidden="props.mode === 'edit'"
                        >
                            Penduduk
                        </Label>
                        <Input
                            v-model="search"
                            placeholder="Ketik nama penduduk"
                            autocomplete="off"
                            :disabled="props.mode === 'edit'"
                        />
                        <div
                            v-if="
                                search.length >= 2 &&
                                pendudukOptions.length &&
                                !penduduk_id
                            "
                            class="autocomplete-dropdown border rounded bg-white shadow mt-1 max-h-40 overflow-auto z-50"
                        >
                            <div
                                v-for="option in pendudukOptions"
                                :key="option.value"
                                class="p-2 hover:bg-blue-100 cursor-pointer"
                                @click="selectPenduduk(option)"
                            >
                                {{ option.label }}
                            </div>
                        </div>
                        <span
                            v-if="pendudukIdError"
                            class="text-red-500 text-sm"
                        >
                            {{ pendudukIdError }}
                        </span>
                    </div>

                    <div class="w-full grid items-center gap-2">
                        <Label for="sebab_kematian" class="text-right"
                            >Sebab Kematian</Label
                        >
                        <div class="col-span-3">
                            <Input
                                v-model="sebab_kematian"
                                type="text"
                                placeholder="Sebab Kematian"
                                class="w-full"
                                name="sebab_kematian"
                            />
                            <span
                                v-if="sebabKematianError"
                                class="text-red-500 text-sm"
                            >
                                {{ sebabKematianError }}
                            </span>
                        </div>
                    </div>

                    <div class="w-full grid items-center gap-2">
                        <Label for="tanggal_kematian" class="text-right"
                            >Tanggal Kematian</Label
                        >
                        <div class="col-span-3">
                            <Datepicker
                                locale="id"
                                :enable-time-picker="false"
                                :format="'dd MMMM yyyy'"
                                v-model="tanggal_kematian"
                            />
                            <span
                                v-if="tanggalKematianError"
                                class="text-red-500 text-sm"
                            >
                                {{ tanggalKematianError }}
                            </span>
                        </div>
                    </div>
                </div>

                <DialogFooter>
                    <Button type="submit">
                        {{
                            mode === "edit" ? "Simpan Perubahan" : "Tambah Data"
                        }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>

<style scoped>
:deep(.dp__cell_inner.dp__active_date) {
    background-color: oklch(0.31 0.0702 152.07) !important; /* biru */
    color: white !important;
    border-radius: 6px;
}

:deep(.dp__cell_inner.dp__today) {
    border: 2px solid oklch(0.31 0.0702 152.07); /* border biru */
    border-radius: 6px;
}

:deep(.dp__action_button) {
    background-color: oklch(0.31 0.0702 152.07); /* warna latar */
    color: white; /* warna teks */
    border-radius: 6px;
    border: none;
}

:deep(.dp__action_button:hover) {
    background-color: oklch(0.22 0.0049 158.96); /* saat hover */
}

.autocomplete-dropdown {
    position: absolute;
    left: 0;
    right: 0;
    z-index: 50;
}
.autocomplete-wrapper {
    position: relative;
}
</style>
