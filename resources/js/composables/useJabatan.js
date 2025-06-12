import { ref, onMounted } from "vue";
import { apiGet, apiPost, apiDelete } from "@/utils/api";
// import Cookies from "js-cookie";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";
import { router } from "@inertiajs/vue3";
// import axios from "axios";

export function useJabatan(uuid) {
    const itemsJabatan = ref([]);
    const isLoadingJabatan = ref(false);
    const pageJabatan = ref(1);
    const perPageJabatan = ref(2);
    const totalPagesJabatan = ref(0);
    const totalItemsJabatan = ref(0);
    const itemJabatan = ref({});
    const searchJabatan = ref("");

    const fetchJabatan = async () => {
        try {
            itemsJabatan.value = [];
            isLoadingJabatan.value = true;

            const res = await apiGet("/jabatan", {
                page: pageJabatan.value,
                per_page: perPageJabatan.value,
                search: searchJabatan.value,
            });
            itemsJabatan.value = res.data.data;
            totalItemsJabatan.value = res.data.total;
            perPageJabatan.value = res.data.per_page;
            totalPagesJabatan.value = res.data.last_page;
            console.log(itemsJabatan.value);
        } catch (error) {
            useErrorHandler(error, "Gagal memuat data jabatan");
        } finally {
            isLoadingJabatan.value = false;
        }
    };

    const createAndEditJabatan = async (formValues, props, emit) => {
        try {
            const formData = new FormData();

            for (const [key, value] of Object.entries(formValues)) {
                formData.append(key, value ?? "");
            }

            if (props.mode === "edit") {
                formData.append("_method", "PUT");
                await apiPost(`/jabatan/${props.initialData?.uuid}`, formData);
            } else {
                await apiPost("/jabatan", formData);
            }

            emit("success");
            emit("update:isOpen", false);
            toast.success(
                props.mode === "edit"
                    ? "Berhasil memperbarui data jabatan"
                    : "Berhasil menambahkan data jabatan"
            );
        } catch (error) {
            useErrorHandler(error, "Gagal menyimpan data jabatan");
        }
    };

    const deleteJabatan = async (uuid) => {
        try {
            await apiDelete(`/jabatan/${uuid}`);
            toast.success("Berhasil menghapus jabatan");
            router.visit("/admin/jabatan");
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus jabatan");
        }
    };

    return {
        itemsJabatan,
        isLoadingJabatan,
        pageJabatan,
        perPageJabatan,
        totalItemsJabatan,
        totalPagesJabatan,
        itemJabatan,
        searchJabatan,
        fetchJabatan,
        createAndEditJabatan,
        deleteJabatan,
    };
}
