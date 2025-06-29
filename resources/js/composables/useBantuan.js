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
    const search = ref(null);
    const selectedKategori = ref(null);
    const statusBantuan = ref(null);

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
            if (statusBantuan.value && statusBantuan.value !== "-") {
                params.status = statusBantuan.value;
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
        // item = ref({});
        try {
            isLoading.value = true;
            const res = await apiGet(`/bantuan/${uuid}`);
            item.value = res.data;
            // console.log(res.data);
        } catch (error) {
            useErrorHandler(error, "Gagal memuat detail bantuan");
        } finally {
            isLoading.value = false;
        }
    };

    // Create bantuan
    const createBantuan = async (values) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            await apiPost("/bantuan", values);
            toast.success("Berhasil Tambah Data Bantuan");
            router.visit(`/admin/bantuan`);
        } catch (error) {
            useErrorHandler(error, "Gagal menyimpan data bantuan");
        } finally {
            isLoading.value = false;
        }
    };

    // Edit data bantuan
    const editDataBantuan = async (uuid, values) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            formData.append("_method", "PUT");
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            await apiPost(`/bantuan/${uuid}`, formData);
            toast.success("Berhasil memperbarui data bantuan");
            router.visit(`/admin/bantuan/${uuid}`);

        } catch (error) {
            useErrorHandler(error, "Gagal memperbarui data bantuan");
        } finally {
            isLoading.value = false;
        }
    };

    const editStatusBantuan = async (uuid, status) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            formData.append("_method", "PUT");
            formData.append("status", status ?? "");

            await apiPost(`/bantuan/${uuid}`, formData);
            toast.success("Berhasil memperbarui status bantuan");
            // router.visit(`/riwayat-bantuan/${uuid}`);
        } catch (error) {
            useErrorHandler(error, "Gagal memperbarui status bantuan");
        } finally {
            isLoading.value = false;
        }
    };

    // Delete bantuan
    const deleteBantuan = async (uuid) => {
        try {
            // isLoading.value = true;
            await apiDelete(`/bantuan/${uuid}`);
            toast.success("Berhasil menghapus bantuan");
            router.visit("/admin/bantuan");
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus bantuan");
        } finally {
            // isLoading.value = false;
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
        statusBantuan,
        fetchBantuan,
        fetchDetailBantuan,
        createBantuan,
        editBantuan: editDataBantuan,
        editStatusBantuan,
        deleteBantuan,
    };
}
