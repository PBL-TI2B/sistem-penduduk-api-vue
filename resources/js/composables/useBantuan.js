import { ref } from "vue";
import { apiGet, apiPost, apiDelete } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";
import { router } from "@inertiajs/vue3";

export function useBantuan() {
    const items = ref([]);
    const item = ref({});
    const isLoading = ref(false);
    const page = ref(1);
    const perPage = ref(10);
    const totalPages = ref(1);
    const totalData = ref(0);
    const search = ref("");
    const selectedKategori = ref("-");

    // Fetch list bantuan
    const fetchBantuan = async () => {
        try {
            items.value = [];
            isLoading.value = true;
            const params = {
                page: page.value,
                per_page: perPage.value,
                search: search.value,
            };
            if (selectedKategori.value && selectedKategori.value !== "-") {
                params.kategori_bantuan_id = selectedKategori.value;
            }
            const res = await apiGet("/bantuan", params);
            items.value = res.data.data;
            perPage.value = res.data.per_page;
            totalPages.value = res.data.last_page;
            totalData.value = res.data.total;
        } catch (error) {
            useErrorHandler(error, "Gagal memuat data bantuan");
        } finally {
            isLoading.value = false;
        }
    };

    // Fetch detail bantuan (untuk halaman edit/detail)
    const fetchDetailBantuan = async (uuid) => {
        if (!uuid) return;
        try {
            isLoading.value = true;
            const res = await apiGet(`/bantuan/${uuid}`);
            item.value = res.data;
        } catch (error) {
            useErrorHandler(error, "Gagal memuat detail bantuan");
        } finally {
            isLoading.value = false;
        }
    };

    // Create bantuan
    const createBantuan = async (values, resetForm) => {
        try {
            const formData = new FormData();
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            await apiPost("/bantuan", formData);
            if (resetForm) resetForm();
            toast.success("Berhasil menambahkan data bantuan");
            router.visit("/bantuan");
        } catch (error) {
            useErrorHandler(error, "Gagal menyimpan data bantuan");
        }
    };

    // Edit bantuan
    const editBantuan = async (uuid, values, resetForm) => {
        try {
            const formData = new FormData();
            formData.append("_method", "PUT");
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            await apiPost(`/bantuan/${uuid}`, formData);
            if (resetForm) resetForm();
            toast.success("Berhasil memperbarui data bantuan");
            router.visit("/bantuan");
        } catch (error) {
            useErrorHandler(error, "Gagal memperbarui data bantuan");
        }
    };

    // Delete bantuan
    const deleteBantuan = async (uuid) => {
        try {
            await apiDelete(`/bantuan/${uuid}`);
            toast.success("Berhasil menghapus bantuan");
            router.visit("/bantuan");
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus bantuan");
        }
    };

    return {
        items,
        item,
        isLoading,
        page,
        perPage,
        totalPages,
        totalData,
        search,
        selectedKategori,
        fetchBantuan,
        fetchDetailBantuan,
        createBantuan,
        editBantuan,
        deleteBantuan,
    };
}
