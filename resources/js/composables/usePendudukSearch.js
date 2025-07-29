import { ref } from 'vue';
import { apiGet } from '@/utils/api';

// In-memory cache
const cache = new Map();

export function usePendudukSearch(params = {}) {
    const options = ref([]);
    const loading = ref(false);

    const search = async (searchTerm) => {
        if (searchTerm.length < 2) {
            options.value = [];
            return;
        }

        const cacheKey = JSON.stringify({ ...params, search: searchTerm });

        if (cache.has(cacheKey)) {
            options.value = cache.get(cacheKey);
            return;
        }

        loading.value = true;
        try {
            const queryParams = new URLSearchParams({
                ...params,
                search: searchTerm,
            }).toString();
            
            const res = await apiGet(`/penduduk?${queryParams}`);
            const mappedOptions = res.data.data.map((p) => ({
                value: p.id.toString(),
                label: p.nama_lengkap,
            }));
            
            cache.set(cacheKey, mappedOptions);
            options.value = mappedOptions;
        } catch (error) {
            options.value = [];
            console.error("Failed to search for residents:", error);
        } finally {
            loading.value = false;
        }
    };

    const clearCache = () => {
        cache.clear();
    };

    return {
        options,
        loading,
        search,
        clearCache,
    };
}
