import { ref } from "vue";
import { apiGet, apiPost, apiDelete } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";
import { router } from "@inertiajs/vue3";

export function useKartuKeluarga(uuid) {
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
            };
            // if (selectedKategori.value && selectedKategori.value !== "-") {
            //     params.kategori_bantuan_id = selectedKategori.value;
            // }
            const res = await apiGet("/kartu-keluarga", params);
            items.value = res.data.data;
            perPage.value = res.data.per_page;
            totalPages.value = res.data.last_page;
            totalData.value = res.data.total;
        } catch (error) {
            useErrorHandler(error, "Gagal memuat data kartu keluarga");
        } finally {
            isLoading.value = false;
        }
    };

    // Fetch detail kartu keluarga (untuk halaman edit/detail)
    const fetchDetailData = async () => {
        try {
            isLoading.value = true;
            const res = await apiGet(`/kartu-keluarga/${uuid}`);
            item.value = res.data;
        } catch (error) {
            useErrorHandler(error, "Gagal memuat detail kartu keluarga");
        } finally {
            isLoading.value = false;
        }
    };

    // Create kartu keluarga
    const createData = async (values) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            await apiPost("/kartu-keluarga", values);
            toast.success("Berhasil Tambah Data kartu keluarga");
            router.visit("/admin/kartu-keluarga");
        } catch (error) {
            useErrorHandler(error, "Gagal menyimpan data kartu keluarga");
        } finally {
            isLoading.value = false;
        }
    };

    // Edit kartu keluarga
    const editData = async (values) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            formData.append("_method", "PUT");
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            await apiPost(`/kartu-keluarga/${uuid}`, formData);
            toast.success("Berhasil memperbarui data kartu keluarga");
            router.visit("/admin/kartu-keluarga");
        } catch (error) {
            useErrorHandler(error, "Gagal memperbarui data kartu keluarga");
        } finally {
            isLoading.value = false;
        }
    };

    // Delete kartu keluarga
    const deleteData = async () => {
        try {
            // isLoading.value = true;
            await apiDelete(`/kartu-keluarga/${uuid}`);
            toast.success("Berhasil menghapus kartu keluarga");
            router.visit("/admin/kartu-keluarga");
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus kartu keluarga");
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
        fetchData,
        fetchDetailData,
        createData,
        editData,
        deleteData,
    };
}
