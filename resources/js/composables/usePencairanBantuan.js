import { ref } from "vue";
import { apiGet, apiPost, apiDelete } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";
import { router } from "@inertiajs/vue3";

export function usePencairanBantuan() {
    const items = ref([]);
    const item = ref({});
    const isLoading = ref(false);
    const page = ref(1);
    const perPage = ref(10);
    const totalPages = ref(1);
    const totalItems = ref(1);
    // const imageUrl = ref(null);

    const search = ref("");
    // const selectedStatusPenerimaanBantuan = ref("");

    //! Fetch Data Penerima Bantuan
    const fetchData = async (penerima_bantuan_id) => {
        // if (!penerima_bantuan_id) {
        //     useErrorHandler(new Error("Parameter penerima_bantuan_id wajib diisi"), "Parameter penerima_bantuan_id wajib diisi");
        //     // items.value = [];
        //     // totalItems.value = 0;
        //     // totalPages.value = 1;
        //     // return;
        // }

        try {
            items.value = [];
            isLoading.value = true;
            const res = await apiGet("/riwayat-bantuan", {
                // page: page.value,
                // search: search.value,
                penerima_bantuan_id,
                // status: selectedStatusPenerimaanBantuan.value,
            });
            items.value = res.data.data;
            perPage.value = res.data.per_page;
            totalPages.value = res.data.last_page;
            totalItems.value = res.data.total;
        } catch (error) {
            useErrorHandler(error, "Gagal memuat data pencairan bantuan");
        } finally {
            isLoading.value = false;
        }
    };

    //! Fetch Detail Penerima Bantuan (untuk halaman edit/detail)
    const fetchDetailData = async (uuid) => {
        if (!uuid) return;

        try {
            isLoading.value = true;
            const res = await apiGet(`/riwayat-bantuan/${uuid}`);
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
            useErrorHandler(error, "Gagal memuat detail pencairan bantuan");
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
            const res = await apiPost("/riwayat-bantuan", values);

            if (res.success === false) {
                toast.error("Penambahan data pencairan bantuan gagal");
                return null;
            }

            toast.success("Berhasil menyimpan data pencairan bantuan");
            return res.data;
            // router.visit("/admin/riwayat-bantuan");
        } catch (error) {
            useErrorHandler(error, "Gagal menyimpan data pencairan bantuan");
            return null;
        } finally {
            isLoading.value = false;
        }
    };

    //! Edit Keterangan Penerima Bantuan
    const editKeterangan = async (uuid, values) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            formData.append("_method", "PUT");
            formData.append("keterangan", keterangan ?? "");

            // for (const [key, value] of Object.entries(values)) {
            //     formData.append(key, value ?? "");
            // }
            await apiPost(`/riwayat-bantuan/${uuid}`, formData);
            toast.success("Berhasil memperbarui keterangan pencairan bantuan");
            router.visit("/admin/riwayat-bantuan");
        } catch (error) {
            useErrorHandler(
                error,
                "Gagal memperbarui keterangan pencairan bantuan"
            );
        } finally {
            isLoading.value = false;
        }
    };

    //! Edit status pencairan only
    const editStatusPencairan = async (uuid, status) => {
        try {
            isLoading.value = true;

            const formData = new FormData();
            formData.append("_method", "PUT");
            formData.append("status", status ?? "");

            await apiPost(`/riwayat-bantuan/${uuid}`, formData);
            toast.success("Berhasil memperbarui status pencairan");
            // router.visit(`/riwayat-bantuan/${uuid}`);
        } catch (error) {
            useErrorHandler(error, "Gagal memperbarui status pencairan");
        } finally {
            isLoading.value = false;
        }
    };

    //! Delete Penerima Bantuan
    const deleteData = async (uuid) => {
        try {
            // isLoading.value = true;
            await apiDelete(`/riwayat-bantuan/${uuid}`);
            toast.success("Berhasil menghapus riwayat-bantuan");
            // router.visit("/admin/riwayat-bantuan");
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus pencairan bantuan");
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
        // selectedStatusPenerimaanBantuan,
        // statusValidasiOptions,
        // imageUrl,
        fetchData,
        fetchDetailData,
        createData,
        editKeterangan,
        editStatusPencairan,
        deleteData,
    };
}
