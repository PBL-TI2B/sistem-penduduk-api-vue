<script setup>
import { ref, computed, reactive, watch } from "vue";
import { apiPost } from "@/utils/api";
import Button from "@/components/ui/button/Button.vue";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";
import { toast } from "vue-sonner";
import { useErrorHandler } from "@/composables/useErrorHandler";

// Props & Emits
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

// Form state
const form = reactive({
  jenjang: "",
});

// Watch data awal untuk edit
watch(
  () => props.initialData,
  (data) => {
    form.jenjang = data.jenjang || "";
  },
  { immediate: true }
);

// Reset form saat dialog ditutup
watch(
  () => props.isOpen,
  (open) => {
    if (!open) {
      form.jenjang = "";
    }
  }
);

// Dialog title dinamis
const title = computed(() =>
  props.mode === "create" ? "Tambah" : "Ubah"
);

// Handle submit form
const handleSubmit = async () => {
  try {
    const formData = new FormData();
    formData.append("jenjang", form.jenjang);

    if (props.mode === "edit") {
      formData.append("_method", "PUT");
      await apiPost(`/pendidikan/${props.initialData.uuid}`, formData);
    } else {
      await apiPost("/pendidikan", formData);
    }

    toast.success(
      props.mode === "edit"
        ? "Berhasil memperbarui data pendidikan"
        : "Berhasil menambahkan data pendidikan"
    );

    emit("success");
    emit("update:isOpen", false);
  } catch (error) {
    useErrorHandler(error, "Gagal menyimpan data pendidikan");
  }
};
</script>

<template>
  <Dialog :open="props.isOpen" @update:open="emit('update:isOpen', $event)">
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle>{{ title }} Pendidikan</DialogTitle>
        <DialogDescription>
          {{
            props.mode === "edit"
              ? "Ubah data pendidikan di bawah ini"
              : "Isi data pendidikan baru di bawah ini"
          }}
        </DialogDescription>
      </DialogHeader>

      <!-- Form -->
      <form @submit.prevent="handleSubmit" class="grid gap-4 py-4">
        <div class="grid items-center gap-2">
          <Label for="jenjang" class="text-right">Jenjang Pendidikan</Label>
          <Input
            id="jenjang"
            v-model="form.jenjang"
            placeholder="Masukkan Jenjang Pendidikan"
          />
        </div>

        <DialogFooter>
          <Button type="submit">
            {{ props.mode === "edit" ? "Simpan Perubahan" : "Tambah" }}
          </Button>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>
