import { ref } from "vue";
import { apiGet, apiPost, apiDelete } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";
import { router } from "@inertiajs/vue3";
import axios from "axios";
import Cookies from "js-cookie";

export function useBerita() {
    const items = ref([]);
    const item = ref({});
    const isLoading = ref(false);
    const page = ref(1);
    const perPage = ref(10);
    const totalPages = ref(1);
    const totalData = ref(0);
    const search = ref("");
    const statusFilter = ref("");
    const previewThumbnail = ref(null);

    // Fetch list berita
    const fetchData = async () => {
        try {
            items.value = [];
            isLoading.value = true;
            const params = {
                page: page.value,
                per_page: perPage.value,
                search: search.value,
                status: statusFilter.value,
            };
            const res = await apiGet("/berita", params);
            items.value = res.data.data;
            perPage.value = res.data.per_page;
            totalPages.value = res.data.last_page;
            totalData.value = res.data.total;
        } catch (error) {
            useErrorHandler(error, "Gagal memuat data berita");
        } finally {
            isLoading.value = false;
        }
    };

    // Fetch detail berita (untuk halaman edit/detail)
    const fetchDetailData = async (uuid) => {
        if (!uuid) return;
        try {
            isLoading.value = true;
            const res = await apiGet(`/berita/${uuid}`);
            item.value = res.data;
            // Ambil thumbnail preview jika ada
            if (item.value.thumbnail) {
                const resImage = await axios.get(
                    `/api/v1/berita/thumbnail/${item.value.thumbnail}`,
                    {
                        responseType: "blob",
                        headers: {
                            Authorization: `Bearer ${Cookies.get("token")}`,
                        },
                    }
                );
                previewThumbnail.value = URL.createObjectURL(resImage.data);
            } else {
                previewThumbnail.value = null;
            }
        } catch (error) {
            useErrorHandler(error, "Gagal memuat detail berita");
        } finally {
            isLoading.value = false;
        }
    };

    // Create berita
    const createData = async (values, thumbnailFile, user_id) => {
        try {
            isLoading.value = true;
            const formData = new FormData();
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            if (thumbnailFile) {
                formData.append("thumbnail", thumbnailFile);
            }
            if (user_id) {
                formData.append("user_id", user_id);
            }
            await apiPost("/berita", formData);
            toast.success("Berhasil tambah data berita");
            router.visit("/admin/berita");
        } catch (error) {
            useErrorHandler(error, "Gagal menyimpan data berita");
        } finally {
            isLoading.value = false;
        }
    };

    // Edit berita
    const editData = async (uuid, values, thumbnailFile, user_id) => {
        try {
            isLoading.value = true;
            const formData = new FormData();
            formData.append("_method", "PUT");
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            if (thumbnailFile) {
                formData.append("thumbnail", thumbnailFile);
            }
            if (user_id) {
                formData.append("user_id", user_id);
            }
            await apiPost(`/berita/${uuid}`, formData);
            toast.success("Berhasil memperbarui data berita");
            router.visit("/admin/berita");
        } catch (error) {
            useErrorHandler(error, "Gagal memperbarui data berita");
        } finally {
            isLoading.value = false;
        }
    };

    // Delete berita
    const deleteData = async (uuid) => {
        try {
            await apiDelete(`/berita/${uuid}`);
            toast.success("Berhasil menghapus data berita");
            router.visit("/admin/berita");
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus data berita");
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
        statusFilter,
        previewThumbnail,
        fetchData,
        fetchDetailData,
        createData,
        editData,
        deleteData,
    };
}