import { ref } from "vue";
import { apiGet, apiPost, apiDelete } from "@/utils/api";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";
import { router } from "@inertiajs/vue3";

export function useKematian() {
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
            const res = await apiGet("/kematian", params);
            items.value = res.data.data;
            perPage.value = res.data.per_page;
            totalPages.value = res.data.last_page;
            totalData.value = res.data.total;
        } catch (error) {
            useErrorHandler(error, "Gagal memuat data kematian");
        } finally {
            isLoading.value = false;
        }
    };

    // Fetch detail kematian (untuk halaman edit/detail)
    const fetchDetailData = async (uuid) => {
        if (!uuid) return;
        // item = ref({});
        try {
            isLoading.value = true;
            const res = await apiGet(`/kematian/${uuid}`);
            item.value = res.data;
            // console.log(res.data);
        } catch (error) {
            useErrorHandler(error, "Gagal memuat detail kematian");
        } finally {
            isLoading.value = false;
        }
    };

    const createAndEditKematian = async (formValues, props, emit) => {
        try {
            const formData = new FormData();

            for (const [key, value] of Object.entries(formValues)) {
                formData.append(key, value ?? "");
            }

            if (props.mode === "edit") {
                formData.append("_method", "PUT");
                await apiPost(`/kematian/${props.initialData?.uuid}`, formData);
            } else {
                await apiPost("/kematian", formData);
            }

            emit("success");
            emit("update:isOpen", false);
            toast.success(
                props.mode === "edit"
                    ? "Berhasil memperbarui data kematian"
                    : "Berhasil menambahkan data kematian"
            );
        } catch (error) {
            useErrorHandler(error, "Gagal menyimpan data kematian");
        }
    };

    // Delete kematian
    const deleteData = async (uuid) => {
        try {
            // isLoading.value = true;
            await apiDelete(`/kematian/${uuid}`);
            toast.success("Berhasil menghapus kematian");
            router.visit("/admin/kematian");
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus kematian");
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
        deleteData,
        createAndEditKematian,
    };
}
