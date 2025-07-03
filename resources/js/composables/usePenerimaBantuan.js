import { ref } from "vue";
import { apiGet, apiPost, apiDelete } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";
import axios from "axios";
import Cookies from "js-cookie";
import { router } from "@inertiajs/vue3";

export function usePenerimaBantuan() {
    const items = ref([]);
    const item = ref({});
    const isLoading = ref(false);
    const page = ref(1);
    const perPage = ref(10);
    const totalPages = ref(1);
    const totalItems = ref(1);
    // const imageUrl = ref(null);

    const search = ref("");
    const selectedStatusPenerimaanBantuan = ref("");

    //! Fetch Data Penerima Bantuan
    const fetchData = async () => {
        try {
            items.value = [];
            isLoading.value = true;
            const res = await apiGet("/penerima-bantuan", {
                page: page.value,
                search: search.value,
                status: selectedStatusPenerimaanBantuan.value,
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
            useErrorHandler(error, "Gagal memuat data penerima bantuan");
        } finally {
            isLoading.value = false;
        }
    };

    //! Fetch Detail Penerima Bantuan (untuk halaman edit/detail)
    const fetchDetailData = async (uuid) => {
        if (!uuid) return;

        try {
            isLoading.value = true;
            const res = await apiGet(`/penerima-bantuan/${uuid}`);
            item.value = res.data;

            // if (items.value.penduduk.foto) {
            //     const resImage = await axios.get(
            //         `/api/v1/penduduk/foto/${items.value.foto}`,
            //         {
            //             responseType: "blob",
            //             headers: {
            //                 Authorization: `Bearer ${Cookies.get("token")}`,
            //             },
            //         }
            //     );
            //     imageUrl.value = URL.createObjectURL(resImage.data);
            // }
        } catch (error) {
            useErrorHandler(error, "Gagal memuat detail penerima bantuan");
        } finally {
            isLoading.value = false;
        }
    };

    //! Create Penerima Bantuan
    const createData = async (values) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }
            const res = await apiPost("/penerima-bantuan", values);

            if (res.success === false) {
                toast.error("Penduduk kurang mampu dengan bantuan yang sama sudah ada");
                return
            }

            toast.success("Berhasil Tambah Data Penerima Bantuan");
            router.visit("/admin/penerima-bantuan");
        } catch (error) {
            useErrorHandler(error, "Gagal menyimpan data penerima bantuan");
        } finally {
            isLoading.value = false;
        }
    };

    //! Edit Keterangan Penerima Bantuan
    const editKeterangan = async (uuid, keterangan) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            formData.append("_method", "PUT");
            formData.append("keterangan", keterangan ?? "");

            // for (const [key, value] of Object.entries(values)) {
            //     formData.append(key, value ?? "");
            // }
            await apiPost(`/penerima-bantuan/${uuid}`, formData);
            toast.success("Berhasil memperbarui keterangan penerima bantuan");
            router.visit("/admin/penerima-bantuan");
        } catch (error) {
            useErrorHandler(
                error,
                "Gagal memperbarui keterangan penerima bantuan"
            );
        } finally {
            isLoading.value = false;
        }
    };

    //! Edit status penerima bantuan only
    const editStatusPenerimaanBantuan = async (uuid, status) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            formData.append("_method", "PUT");
            formData.append("status", status ?? "");

            await apiPost(`/penerima-bantuan/${uuid}`, formData);
            toast.success("Berhasil memperbarui status penerima bantuan");
            // router.visit(`/penerima-bantuan/${uuid}`);
        } catch (error) {
            useErrorHandler(error, "Gagal memperbarui status penerima bantuan");
        } finally {
            isLoading.value = false;
        }
    };

    //! Delete Penerima Bantuan
    const deleteData = async (uuid) => {
        try {
            // isLoading.value = true;
            await apiDelete(`/penerima-bantuan/${uuid}`);
            toast.success("Berhasil menghapus penerima-bantuan");
            router.visit("/admin/penerima-bantuan");
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus penerima bantuan");
        } finally {
            // isLoading.value = false;
        }
    };

    //! Export Show Penerima Bantuan

    const exportShowPenerimaBantuan = async (uuid) => {
        try {
            const response = await axios.get(`/api/v1/penerima-bantuan/${uuid}/export/pdf`, {
                responseType: "blob",
                headers: {
                    Authorization: `Bearer ${Cookies.get("token")}`, // if needed
                },
            });
            const url = window.URL.createObjectURL(new Blob([response.data], { type: 'application/pdf' }));
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", `detail-penerima-${uuid}.pdf`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
        } catch (error) {
            console.error("Failed to export PDF:", error);
            toast.error("Gagal mengekspor PDF penerima bantuan");
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
        selectedStatusPenerimaanBantuan,
        // statusValidasiOptions,
        // imageUrl,
        fetchData,exportShowPenerimaBantuan,
        fetchDetailData,
        createData,
        editKeterangan,
        editStatusPenerimaanBantuan,
        deleteData,
    };
}
