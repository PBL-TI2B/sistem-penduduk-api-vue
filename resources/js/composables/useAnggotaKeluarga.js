import { ref } from "vue";
import { apiGet, apiPost, apiDelete } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";
import { router } from "@inertiajs/vue3";

export function useAnggotaKeluarga() {
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
            const res = await apiGet("/anggota-keluarga", params);
            items.value = res.data.data;
            perPage.value = res.data.per_page;
            totalPages.value = res.data.last_page;
            totalData.value = res.data.total;
        } catch (error) {
            useErrorHandler(error, "Gagal memuat data anggota keluarga");
        } finally {
            isLoading.value = false;
        }
    };

    // Fetch detail anggota keluarga (untuk halaman edit/detail)
    const fetchDetailData = async (uuid) => {
        if (!uuid) return;
        // item = ref({});
        try {
            isLoading.value = true;
            const res = await apiGet(`/anggota-keluarga/${uuid}`);
            item.value = res.data;
            // console.log(res.data);
        } catch (error) {
            useErrorHandler(error, "Gagal memuat detail anggota keluarga");
        } finally {
            isLoading.value = false;
        }
    };

    // Create anggota keluarga
    const createData = async (values) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            await apiPost("/anggota-keluarga", formData);
            toast.success("Berhasil Tambah Data anggota keluarga");
            router.visit("/admin/anggota-keluarga");
        } catch (error) {
            useErrorHandler(error, "Gagal menyimpan data anggota keluarga");
        } finally {
            isLoading.value = false;
        }
    };

    // Edit anggota keluarga
    const editData = async (uuid, values) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            formData.append("_method", "PUT");
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            await apiPost(`/anggota-keluarga/${uuid}`, formData);
            toast.success("Berhasil memperbarui data anggota keluarga");
            router.visit("/admin/anggota-keluarga");
        } catch (error) {
            useErrorHandler(error, "Gagal memperbarui data anggota keluarga");
        } finally {
            isLoading.value = false;
        }
    };

    // Delete anggota keluarga
    const deleteData = async (uuid) => {
        try {
            // isLoading.value = true;
            await apiDelete(`/anggota-keluarga/${uuid}`);
            toast.success("Berhasil menghapus anggota keluarga");
            // router.visit("/admin/anggota-keluarga");
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus anggota keluarga");
        } finally {
            // isLoading.value = false;
        }
    };

    // Hapus anggota keluarga
    const deleteAnggota = async (anggotaUuid) => {
        try {
            await apiDelete(`/anggota-keluarga/${anggotaUuid}`);
            fetchDetailData(); // reload data keluarga
        } catch (e) {
            alert("Gagal menghapus anggota keluarga");
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
        deleteAnggota,
    };
}
