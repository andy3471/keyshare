import { ref, watch } from 'vue';
import axios from 'axios';

export function useAutocomplete(url: string) {
    const query = ref('');
    const results = ref<any[]>([]);
    const loading = ref(false);
    const showResults = ref(false);
    const selectedIndex = ref(-1);

    const search = async (searchQuery: string) => {
        if (!searchQuery || searchQuery.length < 2) {
            results.value = [];
            showResults.value = false;
            return;
        }

        loading.value = true;
        try {
            const response = await axios.get(url, {
                params: { q: searchQuery },
            });
            results.value = response.data;
            showResults.value = results.value.length > 0;
        } catch (error) {
            results.value = [];
            showResults.value = false;
        } finally {
            loading.value = false;
        }
    };

    watch(query, (newQuery) => {
        search(newQuery);
    });

    const select = (item: any) => {
        query.value = item.name || item;
        showResults.value = false;
        return item;
    };

    const hideResults = () => {
        setTimeout(() => {
            showResults.value = false;
        }, 200);
    };

    return {
        query,
        results,
        loading,
        showResults,
        selectedIndex,
        search,
        select,
        hideResults,
    };
}
