import { ref } from "vue";
import { apiGet, apiPost, apiDelete } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";
import { router } from "@inertiajs/vue3";

export function useKurangMampu() {
    const items = ref([]);
    const item = ref({});
    const isLoading = ref(false);
    const page = ref(1);
    const perPage = ref(10);
    const totalPages = ref(1);
    const totalItems = ref(1);

    const search = ref("");
    const selectedStatusValidasi = ref("");
    const statusValidasiOptions = [
        {
            value: null,
            label: "Semua",
        },
        {
            value: "pending",
            label: "Pending",
        },
        {
            value: "terverifikasi",
            label: "Terverifikasi",
        },
        {
            value: "ditolak",
            label: "Ditolak",
        },
    ];

    //! Fetch Data Kurang Mampu
    const fetchData = async () => {
        try {
            items.value = [];
            isLoading.value = true;
            const res = await apiGet("/kurang-mampu", {
                page: page.value,
                search: search.value,
                status_validasi: selectedStatusValidasi.value,
            });
            items.value = res.data.data.map((item) => ({
                ...item,
                nama_penduduk: item.penduduk?.nama_lengkap || "-",
            }));
            perPage.value = res.data.per_page;
            totalPages.value = res.data.last_page;
            totalItems.value = res.data.total;
        } catch (error) {
            useErrorHandler(error, "Gagal memuat data kurang mampu");
        } finally {
            isLoading.value = false;
        }
    };

    // Fetch Detail Kurang Mampu (untuk halaman edit/detail)
    // const fetchDetailData = async (uuid) => {
    //     if (!uuid) return;
    //     // item = ref({});
    //     try {
    //         isLoading.value = true;
    //         const res = await apiGet(`/bantuan/${uuid}`);
    //         item.value = res.data;
    //         // console.log(res.data);
    //     } catch (error) {
    //         useErrorHandler(error, "Gagal memuat detail bantuan");
    //     } finally {
    //         isLoading.value = false;
    //     }
    // };

    //! Create Kurang Mampu
    const createData  = async (values) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            await apiPost("/kurang-mampu", values);
            toast.success("Berhasil Tambah Data KurangMampu");
            router.visit("/kurang-mampu");
        } catch (error) {
            useErrorHandler(error, "Gagal menyimpan data kurang mampu");
        } finally {
            isLoading.value = false;
        }
    };

    // // Edit Kurang Mampu
    // const editData  = async (uuid, values) => {
    //     try {
    //         isLoading.value = true;

    //         const formData = new FormData();
    //         formData.append("_method", "PUT");
    //         for (const [key, value] of Object.entries(values)) {
    //             formData.append(key, value ?? "");
    //         }
    //         await apiPost(`/bantuan/${uuid}`, formData);
    //         toast.success("Berhasil memperbarui data bantuan");
    //         router.visit("/bantuan");
    //     } catch (error) {
    //         useErrorHandler(error, "Gagal memperbarui data bantuan");
    //     } finally {
    //         isLoading.value = false;
    //     }
    // };

    //! Delete Kurang Mampu
    const deleteData  = async (uuid) => {
        try {
            // isLoading.value = true;
            await apiDelete(`/kurang-mampu/${uuid}`);
            toast.success("Berhasil menghapus kurang-mampu");
            router.visit("/kurang-mampu");
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus kurang mampu");
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
        totalItems,
        search,
        selectedStatusValidasi,
        statusValidasiOptions,
        fetchData,
        // fetchDetailData,
        createData,
        // editData,
        deleteData,
    };
}
