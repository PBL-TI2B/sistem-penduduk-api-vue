<script setup>
import { ref, watch, computed, onMounted } from "vue";
import { useForm } from "vee-validate";
import Button from "@/components/ui/button/Button.vue";
import {
    Dialog,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
import Label from "@/components/ui/label/Label.vue";
import Input from "@/components/ui/input/Input.vue";
import Select from "@/components/ui/select/Select.vue";
import SelectTrigger from "@/components/ui/select/SelectTrigger.vue";
import SelectValue from "@/components/ui/select/SelectValue.vue";
import SelectContent from "@/components/ui/select/SelectContent.vue";
import SelectItem from "@/components/ui/select/SelectItem.vue";
import { apiGet, apiPost } from "@/utils/api";

const props = defineProps({
    isOpen: Boolean,
    kkId: [String, Number],
    // statusOptions: { type: Array, default: () => [] },
});
const emit = defineEmits(["update:isOpen", "success"]);

const search = ref("");
const pendudukOptions = ref([]);
const loadingPenduduk = ref(false);
const statusOptions = ref([]);

const { handleSubmit, setValues, values, errors, setFieldValue } = useForm({
    initialValues: {
        penduduk_id: "",
        status_keluarga_id: "",
    },
});

const fetchStatusKeluarga = async () => {
    try {
        const res = await apiGet("/status-keluarga");
        statusOptions.value = res.data.data.map((item) => ({
            value: item.id.toString(),
            label: item.status_keluarga,
        }));
    } catch (error) {
        // opsional: handle error
    }
};

watch(search, async (val) => {
    if (val.length < 2) {
        pendudukOptions.value = [];
        return;
    }
    loadingPenduduk.value = true;
    const res = await apiGet(`/penduduk?search=${val}`);
    pendudukOptions.value = res.data.data.map((p) => ({
        value: p.id,
        label: `${p.nama_lengkap} (${p.nik})`,
    }));
    loadingPenduduk.value = false;
});

onMounted(() => {
    fetchStatusKeluarga();
});

const selectPenduduk = (option) => {
    setFieldValue("penduduk_id", option.value);
    search.value = option.label;
    pendudukOptions.value = [];
};

const onSubmit = handleSubmit(async (formValues) => {
    const payload = {
        ...formValues,
        kk_id: props.kkId, // ambil dari props
    };
    console.log("Payload yang dikirim:", payload); // cek di console

    await apiPost("/anggota-keluarga", payload);

    emit("success");
    emit("update:isOpen", false);
});
</script>

<template>
    <Dialog :open="props.isOpen" @update:open="emit('update:isOpen', $event)">
        <DialogContent>
            <form @submit.prevent="onSubmit">
                <DialogHeader>
                    <DialogTitle>Tambah Anggota Keluarga</DialogTitle>
                </DialogHeader>
                <div class="grid gap-4 py-4">
                    <div>
                        <Label class="mb-2">Nama/NIK Penduduk</Label>
                        <Input
                            v-model="search"
                            placeholder="Ketik nama/NIK penduduk"
                            autocomplete="off"
                        />
                        <div
                            v-if="search.length >= 2 && pendudukOptions.length"
                            class="border rounded bg-white shadow mt-1 max-h-40 overflow-auto z-50"
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
                            v-if="errors.penduduk_id"
                            class="text-red-500 text-sm"
                            >{{ errors.penduduk_id }}</span
                        >
                    </div>
                    <div>
                        <Label class="mb-2">Status Keluarga</Label>
                        <Select
                            :model-value="values.status_keluarga_id"
                            @update:model-value="
                                (val) =>
                                    setFieldValue('status_keluarga_id', val)
                            "
                        >
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Pilih Status..." />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="option in statusOptions"
                                    :key="option.value"
                                    :value="option.value"
                                >
                                    {{ option.label }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <span
                            v-if="errors.status_keluarga_id"
                            class="text-red-500 text-sm"
                            >{{ errors.status_keluarga_id }}</span
                        >
                    </div>
                </div>
                <DialogFooter>
                    <Button type="submit">Tambah</Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
