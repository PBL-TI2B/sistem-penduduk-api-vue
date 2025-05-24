import { ref } from "vue";
import { apiGet} from "@/utils/api";
// import Cookies from "js-cookie";
import { useErrorHandler } from "@/composables/useErrorHandler";
// import { toast } from "vue-sonner";
// import { router } from "@inertiajs/vue3";
// import axios from "axios";

export function useStatistik() {
    const statistikItems = ref([]);
    const demografiItems = ref({});

    const isLoading = ref(false);

     const fetchStatistikByType = async (type) => { // Tambahkan endpoint

        try {
            // demografiItems = ref({});

            isLoading.value = true;

            const res = await apiGet(`/statistik/${type}`);
            console.log(res.data);
            // if (type == "demografi") {
            //     statistikItems.value = res.data
            //     console.log(`Demografi load`);
            //     return
            // }
            statistikItems.value = res.data;
            console.log(`Statistik ${type} loaded `);

        } catch (error) {
            useErrorHandler(error, `Gagal memuat data statistik ${type}`);
            console.log(`Gagal load ${type}`);
        } finally {
            isLoading.value = false;
        }
    };

    return {
        statistikItems,
        isLoading,
        demografiItems,
        fetchStatistikByType,
    };
}
