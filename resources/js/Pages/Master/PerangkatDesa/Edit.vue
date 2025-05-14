<script setup>
import {
    FormField,
    FormItem,
    FormLabel,
    FormControl,
    FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import {
    Select,
    SelectTrigger,
    SelectValue,
    SelectContent,
    SelectItem,
} from "@/components/ui/select";
import { Button } from "@/components/ui/button";
import { useForm } from "vee-validate";
import { getFields } from "./utils/fields";
import BreadcrumbComponent from "@/components/BreadcrumbComponent.vue";
import { onMounted, ref } from "vue";
import { apiGet, apiPost } from "@/utils/api";
import { router, usePage } from "@inertiajs/vue3";
import dayjs from "dayjs";
import { formSchemaPerangkatDesa } from "./utils/form-schema";
import { usePerangkatDesa } from "@/composables/usePerangkatDesa";

const fields = ref([]);
const perangkatDesa = ref(null);
const { uuid } = usePage().props;

const { handleSubmit, resetForm } = useForm({
    validationSchema: formSchemaPerangkatDesa,
    initialValues: {},
});

const { editPerangkatDesa } = usePerangkatDesa(uuid);

const onSubmit = handleSubmit(async (values) => {
    editPerangkatDesa(values, resetForm);
});

onMounted(async () => {
    const [
        pendudukRes,
        jabatanRes,
        periodeJabatanRes,
        desaRes,
        dusunRes,
        rtRes,
        rwRes,
    ] = await Promise.all([
        apiGet("/penduduk"),
        apiGet("/jabatan"),
        apiGet("/periode-jabatan"),
        apiGet("/desa"),
        apiGet("/dusun"),
        apiGet("/rt"),
        apiGet("/rw"),
    ]);

    const mapOptions = (data, labelKey) =>
        data.map((item) => ({
            value: item.id.toString(),
            label: item[labelKey],
        }));

    const penduduk = mapOptions(pendudukRes.data.data, "nama_lengkap");
    const jabatan = mapOptions(jabatanRes.data.data, "jabatan");
    const desa = mapOptions(desaRes.data.data, "nama");
    const dusun = mapOptions(dusunRes.data.data, "nama");
    const rt = mapOptions(rtRes.data.data, "nomor_rt");
    const rw = mapOptions(rwRes.data.data, "nomor_rw");

    const periodeJabatan = periodeJabatanRes.data.data.map((item) => ({
        value: item.id.toString(),
        label: `${dayjs(item.awal_menjabat).format("YYYY")} - ${dayjs(
            item.akhir_menjabat
        ).format("YYYY")}`,
    }));

    fields.value = getFields(
        penduduk,
        jabatan,
        periodeJabatan,
        desa,
        dusun,
        rt,
        rw
    );

    const res = await apiGet(`/perangkat-desa/${uuid}`);
    perangkatDesa.value = res.data;

    resetForm({
        values: {
            status_keaktifan: perangkatDesa.value.status_keaktifan,
            penduduk_id: perangkatDesa.value.penduduk?.id.toString(),
            jabatan_id: perangkatDesa.value.jabatan?.id.toString(),
            periode_jabatan_id:
                perangkatDesa.value.periode_jabatan?.id.toString(),
            desa_id: perangkatDesa.value.desa?.id.toString(),
            dusun_id: perangkatDesa.value.dusun?.id.toString(),
            rt_id: perangkatDesa.value.rt?.id.toString(),
            rw_id: perangkatDesa.value.rw?.id.toString(),
            // tambahkan field lainnya jika ada
        },
    });
});
</script>

<template>
    <Head title="Edit Perangkat Desa" />

    <div class="grid gap-1">
        <h1 class="text-3xl font-bold">Edit Data Perangkat Desa</h1>
        <BreadcrumbComponent
            :items="[
                { label: 'Dashboard', href: '/' },
                { label: 'Data Perangkat Desa', href: '/perangkat-desa' },
                { label: 'Edit Data Perangkat Desa' },
            ]"
        />
    </div>

    <div class="shadow-lg p-8 my-4 rounded-lg">
        <form @submit="onSubmit" class="space-y-6 grid grid-cols-2 gap-x-8">
            <FormField
                v-for="field in fields"
                :key="field.name"
                :name="field.name"
                v-slot="{ componentField }"
            >
                <FormItem>
                    <FormLabel>{{ field.label }}</FormLabel>
                    <FormControl>
                        <Input
                            v-if="
                                field.type === 'text' || field.type === 'date'
                            "
                            :type="field.type"
                            :placeholder="field.placeholder"
                            v-bind="componentField"
                        />
                        <Select
                            v-else-if="field.type === 'select'"
                            v-bind="componentField"
                        >
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Pilih..." />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="option in field.options"
                                    :key="option.value || option"
                                    :value="option.value || option"
                                >
                                    {{ option.label || option }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>

            <div class="flex col-span-2 justify-between items-center">
                <p>Pastikan semua data sudah benar sebelum menyimpan.</p>
                <div class="flex gap-2 items-center">
                    <Button
                        @click="router.visit('/perangkat-desa')"
                        type="button"
                        variant="secondary"
                    >
                        Batal
                    </Button>
                    <Button type="submit">Simpan Perubahan</Button>
                </div>
            </div>
        </form>
    </div>
</template>
