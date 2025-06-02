import { ref, onMounted } from "vue";
import { apiGet, apiPost, apiDelete } from "@/utils/api";
import Cookies from "js-cookie";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";
import { router } from "@inertiajs/vue3";
import axios from "axios";

export function usePerangkatDesa(uuid) {
    const items = ref([]);
    const isLoading = ref(false);
    const page = ref(1);
    const perPage = ref(10);
    const totalPages = ref(0);
    const totalItems = ref(0);
    const item = ref({});
    const imageUrl = ref(null);

    const fetchPerangkatDesa = async () => {
        try {
            items.value = [];
            isLoading.value = true;
            const res = await apiGet("/perangkat-desa", { page: page.value });
            items.value = res.data.data;
            perPage.value = res.data.per_page;
            totalItems.value = res.data.total;
            totalPages.value = res.data.last_page;
        } catch (error) {
            useErrorHandler(error, "Gagal memuat data perangkat desa");
        } finally {
            isLoading.value = false;
        }
    };

    const fetchDetailPerangkatDesa = async () => {
        try {
            const res = await apiGet(`/perangkat-desa/${uuid}`);
            item.value = res.data;

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
            router.visit("/perangkat-desa");
        } catch (error) {
            useErrorHandler(error);
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
            router.visit("/perangkat-desa");
        } catch (error) {
            useErrorHandler(error);
        }
    };

    const deletePerangkatDesa = async (uuid) => {
        try {
            await apiDelete(`/perangkat-desa/${uuid}`);
            toast.success("Berhasil Hapus Data Perangkat Desa");
            router.visit("/perangkat-desa");
        } catch (error) {
            useErrorHandler(error);
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
