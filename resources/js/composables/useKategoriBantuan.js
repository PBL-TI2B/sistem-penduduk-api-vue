import { ref, onMounted } from "vue";
import { apiGet, apiPost, apiDelete } from "@/utils/api";
// import Cookies from "js-cookie";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { toast } from "vue-sonner";
import { router } from "@inertiajs/vue3";
// import axios from "axios";

export function useKategoriBantuan(uuid) {
    const itemsKategori = ref([]);
    const isLoadingKategori = ref(false);
    const pageKategori = ref(1);
    const perPageKategori = ref(2);
    const totalPagesKategori = ref(0);
    const totalDataKategori = ref(0);
    const itemKategori = ref({});
    const itemsFilterKategori = ref([]);

    const fetchKategori = async () => {
        try {
            itemsKategori.value = [];
            isLoadingKategori.value = true;

            // Fetch main kategori data with current pagination
            const res = await apiGet("/kategori-bantuan", {
                page: pageKategori.value,
                per_page: perPageKategori.value,
            });

                        // Fetch main kategori data with current pagination
            const resForFilter = await apiGet("/kategori-bantuan", {
                page: 1,
                per_page: 111,
            });

            itemsKategori.value = res.data.data;
            perPageKategori.value = res.data.per_page;
            totalPagesKategori.value = res.data.last_page;
            totalDataKategori.value = res.data.total;
            itemsFilterKategori.value = [
                { value: "-", label: "Semua" },
                ...resForFilter.data.data.map(kat => ({
                    value: kat.id,
                    label: kat.kategori.charAt(0).toUpperCase() + kat.kategori.slice(1)
                }))
            ];
            console.log(itemsKategori.value);
        } catch (error) {
            useErrorHandler(error, "Gagal memuat data kategori");
        } finally {
            isLoadingKategori.value = false;
        }
    };

    const createAndEditKategori = async (formValues, props, emit) => {
        try {
            const formData = new FormData();

            for (const [key, value] of Object.entries(formValues)) {
                formData.append(key, value ?? "");
            }

            if (props.mode === "edit") {
                formData.append("_method", "PUT");
                await apiPost(`/kategori-bantuan/${props.initialData?.uuid}`, formData);
            } else {
                await apiPost("/kategori-bantuan", formData);
            }

            emit("success");
            emit("update:isOpen", false);
            toast.success(
                props.mode === "edit"
                    ? "Berhasil memperbarui data kategori"
                    : "Berhasil menambahkan data kategori"
            );
        } catch (error) {
            useErrorHandler(error, "Gagal menyimpan data kategori");
        }
    };

    const deleteKategori = async (uuid) => {
        try {
            await apiDelete(`/kategori-bantuan/${uuid}`);
            toast.success("Berhasil menghapus kategori");
            router.visit("/bantuan");
        } catch (error) {
            useErrorHandler(error, "Gagal menghapus kategori");
        }
    };

    return {
        itemsKategori,
        itemsFilterKategori,
        isLoadingKategori,
        pageKategori,
        perPageKategori,
        totalPagesKategori,
        itemKategori,
        totalDataKategori,
        fetchKategori,
        createAndEditKategori,
        deleteKategori,
    };
}
