<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { useForm } from "vee-validate";
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
import Select from "@/components/ui/select/Select.vue";
import SelectContent from "@/components/ui/select/SelectContent.vue";
import SelectItem from "@/components/ui/select/SelectItem.vue";
import SelectTrigger from "@/components/ui/select/SelectTrigger.vue";
import SelectValue from "@/components/ui/select/SelectValue.vue";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { apiGet, apiPost } from "@/utils/api";
import { toast } from "vue-sonner";
import Input from "@/components/ui/input/Input.vue";

// Data
const desaOptions = ref([]);

// Props
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

// Emits
const emit = defineEmits(["update:isOpen", "success"]);

// Form Setup
const { handleSubmit, resetForm, setValues, values } = useForm({
    initialValues: {
        nama: "",
        deskripsi: "",
        lokasi: "",
        desa_id: "",
    },
});

const selectedDesa = computed({
    get: () => values.desa_id,
    set: (val) => setValues({ desa_id: val }),
});

const loadDesaOptions = async () => {
    try {
        const res = await apiGet("/desa");
        desaOptions.value = res.data.data;
    } catch (error) {
        useErrorHandler(error, "Gagal memuat data desa");
    }
};

const onSubmit = handleSubmit(async (formValues) => {
    try {
        const formData = new FormData();
        for (const [key, value] of Object.entries(formValues)) {
            formData.append(key, value ?? "");
        }

        if (props.mode === "edit") {
            formData.append("_method", "PUT");
            await apiPost(`/dusun/${props.initialData?.uuid}`, formData);
        } else {
            await apiPost("/dusun", formData);
        }

        emit("success");
        emit("update:isOpen", false);
        toast.success(
            props.mode === "edit"
                ? "Berhasil memperbarui data dusun"
                : "Berhasil menambahkan data dusun"
        );
    } catch (error) {
        console.error("Error submitting:", error);
        useErrorHandler(error, "Gagal menyimpan data dusun");
    }
});

watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen && props.mode === "edit") {
            setValues({
                nama: props.initialData.nama || "",
                deskripsi: props.initialData.deskripsi || "",
                lokasi: props.initialData.lokasi || "",
                desa_id: props.initialData.desa_id || "",
            });
        } else if (isOpen && props.mode === "create") {
            setValues({
                nama: "",
                deskripsi: "",
                lokasi: "",
                desa_id: "",
            });
        } else if (!isOpen) {
            resetForm();
        }
    },
    { immediate: true }
);

onMounted(() => {
    loadDesaOptions();
});

const dialogTitle = computed(() =>
    props.mode === "create" ? "Tambah Dusun" : "Edit Dusun"
);
</script>

<template>
  <Dialog :open="isOpen" @update:open="val => emit('update:isOpen', val)">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>{{ dialogTitle }}</DialogTitle>
        <DialogDescription>
          Lengkapi form berikut untuk menyimpan data dusun.
        </DialogDescription>
      </DialogHeader>

      <form @submit.prevent="onSubmit" class="space-y-4">
        <div>
          <Label for="nama">Nama Dusun</Label>
          <Input id="nama" v-model="values.nama" />
        </div>

        <div>
          <Label for="deskripsi">Deskripsi</Label>
          <Input id="deskripsi" v-model="values.deskripsi" />
        </div>

        <div>
          <Label for="lokasi">Lokasi</Label>
          <Input id="lokasi" v-model="values.lokasi" />
        </div>

        <div>
          <Label for="desa">Desa</Label>
          <Select v-model="selectedDesa">
            <SelectTrigger>
              <SelectValue placeholder="Pilih desa" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem
                v-for="desa in desaOptions"
                :key="desa.id"
                :value="desa.id"
              >
                {{ desa.nama }}
              </SelectItem>
            </SelectContent>
          </Select>
        </div>

        <DialogFooter>
          <Button type="submit">Simpan</Button>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>