import { ref } from "vue";
import { apiGet, apiPost, apiDelete } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import Cookies from "js-cookie";
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
    const imageUrl = ref(null);

    const search = ref("");
    const selectedStatusValidasi = ref("");
    const statusValidasiOptions = [
        {
            value: null,
            label: "Semua",
        },
        {
            value: "belum tervalidasi",
            label: "Belum Tervalidasi",
        },
        {
            value: "tervalidasi",
            label: "Tervalidasi",
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
            // items.value = res.data.data.map((item) => ({
            //     ...item,
            //     nama_penduduk: item.penduduk?.nama_lengkap || "-",
            // }));
            items.value = res.data.data;
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
    const fetchDetailData = async (uuid) => {
        if (!uuid) return;

        try {
            isLoading.value = true;
            const res = await apiGet(`/kurang-mampu/${uuid}`);
            item.value = res.data;

            if (item.value.penduduk.foto) {
                const resImage = await axios.get(
                    `/api/v1/penduduk/foto/${item.value.penduduk.foto}`,
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
            useErrorHandler(error, "Gagal memuat detail kurang mampu");
        } finally {
            isLoading.value = false;
        }
    };

    //! Create Kurang Mampu
    const createData = async (values) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            await apiPost("/kurang-mampu", values);
            toast.success("Berhasil Tambah Data KurangMampu");
            router.visit("/admin/kurang-mampu");
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

    //! Edit status_validasi only
    const editStatusValidasi = async (uuid, status_validasi) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            formData.append("_method", "PUT");
            formData.append("status_validasi", status_validasi ?? "");

            await apiPost(`/kurang-mampu/${uuid}`, formData);
            toast.success("Berhasil memperbarui status validasi");
            // router.visit(`/kurang-mampu/${uuid}`);
        } catch (error) {
            useErrorHandler(error, "Gagal memperbarui status validasi");
        } finally {
            isLoading.value = false;
        }
    };

    //! Edit pendapatan_per_hari, pendapatan_per_bulan, jumlah_tanggungan, keterangan
    const editDataDetails = async (uuid, values) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            formData.append("_method", "PUT");
            formData.append(
                "pendapatan_per_hari",
                values.pendapatan_per_hari ?? ""
            );
            formData.append(
                "pendapatan_per_bulan",
                values.pendapatan_per_bulan ?? ""
            );
            formData.append(
                "jumlah_tanggungan",
                values.jumlah_tanggungan ?? ""
            );
            formData.append("keterangan", values.keterangan ?? "");

            await apiPost(`/kurang-mampu/${uuid}`, formData);
            toast.success("Berhasil memperbarui data kurang mampu");
            // router.visit(`/admin/kurang-mampu/${uuid}`);
        } catch (error) {
            useErrorHandler(error, "Gagal memperbarui data kurang mampu");
        } finally {
            isLoading.value = false;
        }
    };

    //! Delete Kurang Mampu
    const deleteData = async (uuid) => {
        try {
            // isLoading.value = true;
            await apiDelete(`/kurang-mampu/${uuid}`);
            toast.success("Berhasil menghapus kurang-mampu");
            router.visit("/admin/kurang-mampu");
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
        imageUrl,
        fetchData,
        fetchDetailData,
        createData,
        // editData,
        editStatusValidasi,
        editDataDetails,
        deleteData,
    };
}
