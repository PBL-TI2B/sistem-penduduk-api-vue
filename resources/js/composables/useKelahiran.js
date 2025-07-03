import { ref } from "vue";
import { apiGet, apiPost, apiDelete } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";
import { router } from "@inertiajs/vue3";

export function useKelahiran() {
    const items = ref([]);
    const item = ref({});
    const isLoading = ref(false);
    const page = ref(1);
    const perPage = ref(10);
    const totalPages = ref(1);
    const totalData = ref(0);
    const search = ref(null);

    // Fetch list bantuan
    const fetchData = async () => {
        try {
            items.value = [];
            isLoading.value = true;

            const params = {
                page: page.value,
                per_page: perPage.value,
                search: search.value,
                bulan: filter.value.bulan,
                tahun: filter.value.tahun,
                berat: filter.value.berat,
                panjang: filter.panjang,
                anak_ke: filter.value.anak_ke,
            };

            const res = await apiGet("/kelahiran", params);

            items.value = res.data.data;
            perPage.value = res.data.per_page;
            totalPages.value = res.data.last_page;
            totalData.value = res.data.total;
        } catch (error) {
            useErrorHandler(error, "Gagal memuat data kelahiran");
        } finally {
            isLoading.value = false;
        }
    };

    const fetchDetailData = async (uuid) => {
        if (!uuid) return null;
        try {
            isLoading.value = true;
            const res = await apiGet(`/kelahiran/${uuid}`);
            item.value = res.data;
            return res.data; // ⬅️ penting
        } catch (error) {
            useErrorHandler(error, "Gagal memuat detail kelahiran");
            return null;
        } finally {
            isLoading.value = false;
        }
    };

    // Create kelahiran
    const createData = async (values) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            await apiPost("/kelahiran", values);
            toast.success("Berhasil Tambah Data kelahiran");
            router.visit("/admin/kelahiran");
        } catch (error) {
            useErrorHandler(error, "Gagal menyimpan data kelahiran");
        } finally {
            isLoading.value = false;
        }
    };

    // Edit kelahiran
    const editData = async (uuid, values) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            formData.append("_method", "PUT");
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            await apiPost(`/kelahiran/${uuid}`, formData);
            toast.success("Berhasil memperbarui data kelahiran");
            router.visit("/admin/kelahiran");
        } catch (error) {
            useErrorHandler(error, "Gagal memperbarui data kelahiran");
        } finally {
            isLoading.value = false;
        }
    };

    // Delete kelahiran
    const deleteData = async (uuid) => {
        try {
            // isLoading.value = true;
            await apiDelete(`/kelahiran/${uuid}`);
            toast.success("Berhasil menghapus kelahiran");
            router.visit("/admin/kelahiran");
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus kelahiran");
        } finally {
            // isLoading.value = false;
        }
    };

    const filter = ref({
        bulan: "",
        tahun: "",
        min_berat: "",
        max_berat: "",
        min_panjang: "",
        max_panjang: "",
        anak_ke: "",
    });

    return {
        items,
        item,
        isLoading,
        page,
        perPage,
        totalPages,
        totalData,
        search,
        filter,
        fetchData,
        fetchDetailData,
        createData,
        editData,
        deleteData,
    };
}
