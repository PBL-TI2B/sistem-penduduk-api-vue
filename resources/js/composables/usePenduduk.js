import { ref, onUnmounted } from "vue";
import { apiGet, apiDelete, apiPost } from "@/utils/api";
import Cookies from "js-cookie";
import axios from "axios";
import { useErrorHandler } from "./useErrorHandler";
import { toast } from "vue-sonner";
import { router } from "@inertiajs/vue3";

export function usePenduduk(uuid) {
    const items = ref({});
    const imageUrl = ref(null);
    const fotoFile = ref(null);

    const fetchDetailPenduduk = async () => {
        try {
            const res = await apiGet(`penduduk/${uuid}`);
            items.value = res.data;

            if (items.value.foto) {
                const resImage = await axios.get(
                    `/api/v1/penduduk/foto/${items.value.foto}`,
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
            useErrorHandler(error, "Gagal memuat detail penduduk.");
        }
    };

    const createPenduduk = async (values, resetForm) => {
        try {
            const formData = new FormData();
            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }

            if (fotoFile.value) {
                formData.append("foto", fotoFile.value);
            }

            await apiPost("/penduduk", formData);

            resetForm();
            toast.success("Berhasil Tambah Data Penduduk");
            router.visit("/penduduk");
        } catch (error) {
            useErrorHandler(error);
        }
    };

    const editPenduduk = async (values, resetForm) => {
        try {
            const formData = new FormData();
            formData.append("_method", "PUT");

            for (const [key, value] of Object.entries(values)) {
                formData.append(key, value ?? "");
            }

            if (fotoFile.value) {
                formData.append("foto", fotoFile.value);
            }

            await apiPost(`/penduduk/${uuid}`, formData);
            resetForm();

            toast.success("Berhasil memperbarui data");
            router.visit("/penduduk");
        } catch (error) {
            useErrorHandler(error);
        }
    };

    const deletePenduduk = async () => {
        try {
            await apiDelete(`penduduk/${uuid}`);
            toast.success("Data penduduk berhasil dihapus");
            router.visit("/penduduk");
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus data penduduk.");
        }
    };

    const deleteDomisili = async () => {
        try {
            await apiDelete(`/domisili/${items.value.domisili?.uuid}`);
            toast.success("Data domisili berhasil dihapus");
            router.visit("/domisili");
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus data domisili.");
        }
    };

    onUnmounted(() => {
        if (imageUrl.value) {
            URL.revokeObjectURL(imageUrl.value);
        }
    });

    return {
        items,
        imageUrl,
        fetchDetailPenduduk,
        createPenduduk,
        editPenduduk,
        deletePenduduk,
        deleteDomisili,
    };
}
