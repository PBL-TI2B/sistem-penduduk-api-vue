<script setup>
import { ref, computed, reactive, watch, onMounted } from "vue";
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
import {
    Select,
    SelectTrigger,
    SelectValue,
    SelectContent,
    SelectItem,
} from "@/components/ui/select";
import { usePerangkatDesa } from "@/composables/usePerangkatDesa";

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

// Opsi Role
const roleOptions = [
    { value: "superadmin", label: "Superadmin" },
    { value: "admin", label: "Admin" },
    { value: "rt", label: "RT" },
    { value: "rw", label: "RW" },
];

// State form
const form = reactive({
    username: "",
    password: "",
    status: "",
    perangkat_id: "",
    roles: "",
});

// Ambil data perangkat desa
const { fetchPerangkatDesa } = usePerangkatDesa();
const perangkatOptions = ref([]);
const loadPerangkatDesa = async () => {
    const res = await fetchPerangkatDesa();
    perangkatOptions.value = res.data.data.map((item) => ({
        value: item.id,
        label: item.penduduk.nama_lengkap || "Perangkat",
    }));
};

// Load saat dialog dibuka
watch(
    () => props.isOpen,
    async (open) => {
        if (open) {
            await loadPerangkatDesa();
        } else {
            // reset form
            form.username = "";
            form.password = "";
            form.status = "";
            form.perangkat_id = "";
            form.roles = "";
        }
    },
    { immediate: true }
);

// Watch initial data for edit
watch(
    () => props.initialData,
    (data) => {
        form.username = data?.username || "";
        form.password = data?.password || "";
        form.status = data?.status || "";
        form.perangkat_id = data?.perangkat_id || "";
        form.roles = data?.roles[0].name || "";
    },
    { immediate: true }
);

// Title
const title = computed(() => (props.mode === "create" ? "Tambah" : "Ubah"));
console.log(props.initialData);

// Submit handler
const handleSubmit = async () => {
    try {
        const formData = new FormData();
        formData.append("username", form.username);
        formData.append("perangkat_id", form.perangkat_id);
        formData.append("status", form.status);
        formData.append("roles", form.roles);

        // Hanya kirim password jika diisi
        if (form.password && form.password.trim() !== "") {
            formData.append("password", form.password);
        }

        if (props.mode === "edit") {
            formData.append("_method", "PUT");
            await apiPost(`/user/${props.initialData.uuid}`, formData);
        } else {
            await apiPost("/user", formData);
        }

        toast.success(
            props.mode === "edit"
                ? "Berhasil memperbarui data user"
                : "Berhasil menambahkan data user"
        );

        emit("success");
        emit("update:isOpen", false);
    } catch (error) {
        useErrorHandler(error, "Gagal menyimpan data user");
    }
};
</script>

<template>
    <Dialog :open="props.isOpen" @update:open="emit('update:isOpen', $event)">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>{{ title }} User</DialogTitle>
                <DialogDescription>
                    {{
                        props.mode === "edit"
                            ? "Ubah data user di bawah ini"
                            : "Isi data user baru di bawah ini"
                    }}
                </DialogDescription>
            </DialogHeader>

            <!-- Form -->
            <form @submit.prevent="handleSubmit" class="grid gap-4 py-4">
                <div class="grid items-center gap-2">
                    <Label for="username" class="text-right">Username</Label>
                    <Input
                        id="username"
                        v-model="form.username"
                        placeholder="Masukkan username"
                    />
                </div>
                <div class="grid items-center gap-2">
                    <Label for="password" class="text-right">Password</Label>
                    <Input
                        type="password"
                        id="password"
                        v-model="form.password"
                        placeholder="Masukkan password (opsional)"
                    />
                </div>
                <div class="grid items-center gap-2">
                    <Label for="status" class="text-right">Status</Label>
                    <Input
                        id="status"
                        v-model="form.status"
                        placeholder="Masukkan status (aktif atau nonaktif)"
                    />
                </div>
                <!-- Perangkat Desa -->
                <div class="grid items-center gap-2">
                    <Label for="perangkat_id" class="text-right"
                        >Perangkat Desa</Label
                    >
                    <Select v-model="form.perangkat_id">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Pilih..." />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem
                                v-for="option in perangkatOptions"
                                :key="option.value"
                                :value="option.value"
                            >
                                {{ option.label }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                <!-- Role -->
                <div class="grid items-center gap-2">
                    <Label for="roles" class="text-right">Role</Label>
                    <Select v-model="form.roles">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Pilih..." />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem
                                v-for="option in roleOptions"
                                :key="option.value"
                                :value="option.value"
                            >
                                {{ option.label }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                <DialogFooter>
                    <Button type="submit">
                        {{
                            props.mode === "edit"
                                ? "Simpan Perubahan"
                                : "Tambah"
                        }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
