import { ref, onMounted } from "vue";
import { apiGet, apiPost, apiDelete } from "@/utils/api";
import Cookies from "js-cookie";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";
import { router } from "@inertiajs/vue3";
// import axios from "axios";

export function usePerangkatDesa(uuid) {
    const items = ref([]);
    const isLoading = ref(false);
    const page = ref(1);
    const perPage = ref(10);
    const totalPages = ref(0);
    const totalItems = ref(0);
    const item = ref({});
    const imageUrl = ref(null);

    const fetchPerangkatDesa = async (filters = {}) => {
        try {
            items.value = [];
            isLoading.value = true;

            console.log("DEBUG usePerangkatDesa: Filters received by fetchPerangkatDesa:", filters);

            const params = {
                page: page.value,
                per_page: perPage.value,
                jabatan: filters.jabatan || null,
                status_keaktifan: filters.status_keaktifan || null,
                // --- KOREKSI PENTING DI SINI ---
                // Pastikan search selalu string, bahkan jika kosong
                search: filters.search !== undefined && filters.search !== null ? filters.search : '',
            };

            console.log("DEBUG usePerangkatDesa: Params sent to /perangkat-desa API:", params);

            const res = await apiGet("/perangkat-desa", params);

            console.log("DEBUG usePerangkatDesa: Full API Response data for /perangkat-desa:", res.data);

            if (res.data && res.data.data && Array.isArray(res.data.data.data)) {
                items.value = res.data.data.data;
                perPage.value = res.data.data.per_page;
                totalItems.value = res.data.data.total;
                totalPages.value = res.data.data.last_page;
            } else if (res.data && Array.isArray(res.data.data)) {
                items.value = res.data.data;
                perPage.value = res.data.per_page;
                totalItems.value = res.data.total;
                totalPages.value = res.data.last_page;
            }
            else {
                console.warn("WARNING usePerangkatDesa: Unexpected API response structure for Perangkat Desa:", res.data);
                items.value = [];
                perPage.value = 10;
                totalItems.value = 0;
                totalPages.value = 0;
            }

            console.log("DEBUG usePerangkatDesa: Fetched Perangkat Desa data (items.value):", items.value);
            console.log("DEBUG usePerangkatDesa: Perangkat Desa Pagination Info:", {
                total: totalItems.value,
                per_page: perPage.value,
                last_page: totalPages.value
            });

            return res;
        } catch (error) {
            useErrorHandler(error, "Gagal memuat data perangkat desa");
            console.error("ERROR usePerangkatDesa: Error fetching perangkat desa:", error);
        } finally {
            isLoading.value = false;
        }
    };

    const fetchDetailPerangkatDesa = async () => {
        try {
            const res = await apiGet(`/perangkat-desa/${uuid}`);
            item.value = res.data.data || res.data;
            console.log("DEBUG usePerangkatDesa: Fetched Detail Perangkat Desa:", item.value);

            if (item.value.foto) {
                const resImage = await axios.get(
                    `/api/v1/penduduk/foto/${item.value.foto}`,
                    {
                        responseType: "blob",
                        headers: {
                            Authorization: `Bearer ${Cookies.get("token")}`,
                        },
                    }
                );
                imageUrl.value = URL.createObjectURL(resImage.data);
            }
        } catch (error) {
            useErrorHandler(error, "Gagal mendapatkan data perangkat desa");
            console.error("ERROR usePerangkatDesa: Error fetching detail perangkat desa:", error);
        }
    };

    const createPerangkatDesa = async (values, resetForm) => {
        try {
            const formData = new FormData();
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }

            await apiPost("/perangkat-desa", formData);
            resetForm();
            toast.success("Berhasil Tambah Data Perangkat Desa");
            router.visit("/admin/perangkat-desa");
            fetchPerangkatDesa({ jabatan: null, status_keaktifan: null, search: '' }); // Pastikan search kosong
        } catch (error) {
            useErrorHandler(error);
            console.error("ERROR usePerangkatDesa: Error creating perangkat desa:", error);
        }
    };

    const editPerangkatDesa = async (values, resetForm) => {
        try {
            const formData = new FormData();
            formData.append("_method", "PUT");

            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }

            await apiPost(`/perangkat-desa/${uuid}`, formData);
            resetForm();
            toast.success("Berhasil Edit Data Perangkat Desa");
            router.visit("/admin/perangkat-desa");
            fetchPerangkatDesa({ jabatan: null, status_keaktifan: null, search: '' }); // Pastikan search kosong
        } catch (error) {
            useErrorHandler(error);
            console.error("ERROR usePerangkatDesa: Error editing perangkat desa:", error);
        }
    };

    const deletePerangkatDesa = async (uuidToDelete) => {
        try {
            await apiDelete(`/perangkat-desa/${uuidToDelete}`);
            toast.success("Berhasil Hapus Data Perangkat Desa");
            router.visit("/admin/perangkat-desa");
            fetchPerangkatDesa({ jabatan: null, status_keaktifan: null, search: '' }); // Pastikan search kosong
        } catch (error) {
            useErrorHandler(error);
            console.error("ERROR usePerangkatDesa: Error deleting perangkat desa:", error);
        }
    };

    return {
        totalPages,
        page,
        perPage,
        totalItems,
        items,
        isLoading,
        item,
        imageUrl,
        fetchPerangkatDesa,
        fetchDetailPerangkatDesa,
        createPerangkatDesa,
        editPerangkatDesa,
        deletePerangkatDesa,
    };
}
