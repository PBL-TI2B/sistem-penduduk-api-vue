<script setup>
import { ref, computed, watch, onMounted } from "vue";
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
import Select from "@/components/ui/select/Select.vue";
import SelectContent from "@/components/ui/select/SelectContent.vue";
import SelectItem from "@/components/ui/select/SelectItem.vue";
import SelectTrigger from "@/components/ui/select/SelectTrigger.vue";
import SelectValue from "@/components/ui/select/SelectValue.vue";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { apiGet, apiPost } from "@/utils/api";
import { toast } from "vue-sonner";
import Input from "@/components/ui/input/Input.vue";

// Props dan Emits
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

// Load data desa
const desaOptions = ref([]);

const loadDesaOptions = async () => {
  try {
    const res = await apiGet("/desa");
    desaOptions.value = res.data.data;
  } catch (error) {
    useErrorHandler(error, "Gagal memuat data desa");
  }
};

// Setup form vee-validate tanpa initialValues karena nanti kita set manual via setValues
const { handleSubmit, resetForm, setValues } = useForm();

// Setup fields
const { value: nama } = useField("nama");
const { value: deskripsi } = useField("deskripsi");
const { value: lokasi } = useField("lokasi");
const { value: desa_id } = useField("desa_id");

// Submit handler
const onSubmit = handleSubmit(async (formValues) => {
  try {
    const formData = new FormData();

    // Jika kamu mau mengirim penduduk_id dari initialData atau dari mana
    formData.append("penduduk_id", props.initialData?.penduduk_id ?? "");

    for (const [key, value] of Object.entries(formValues)) {
      formData.append(key, value ?? "");
    }

    if (props.mode === "edit") {
      formData.append("_method", "PUT");
      await apiPost(`/dusun/${props.initialData?.domisili?.uuid}`, formData);
    } else {
      await apiPost("/dusun", formData);
    }

    toast.success(
      props.mode === "edit"
        ? "Berhasil memperbarui data domisili"
        : "Berhasil menambahkan data domisili"
    );

    emit("success");
    emit("update:isOpen", false);
  } catch (error) {
    console.error("Error submitting:", error);
    console.log("Form values:", formValues);
    useErrorHandler(error, "Gagal menyimpan data domisili");
  }
});

// Watch props.isOpen untuk reset atau setValues sesuai mode
watch(
  () => props.isOpen,
  (isOpen) => {
    if (isOpen) {
      if (props.mode === "edit") {
        // Set nilai field dari initialData
        setValues({
          nama: props.initialData.nama || "",
          deskripsi: props.initialData.deskripsi || "",
          lokasi: props.initialData.lokasi || "",
          desa_id: props.initialData.desa_id || "",
        });
      } else {
        resetForm();
      }
    } else {
      resetForm();
    }
  },
  { immediate: true }
);

// Load desa options saat mounted
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
          <Input id="nama" v-model="nama" />
        </div>

        <div>
          <Label for="deskripsi">Deskripsi</Label>
          <Input id="deskripsi" v-model="deskripsi" />
        </div>

        <div>
          <Label for="lokasi">Lokasi</Label>
          <Input id="lokasi" v-model="lokasi" />
        </div>

        <div>
          <Label for="desa">Desa</Label>
          <Select v-model="desa_id">
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
