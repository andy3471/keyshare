<script setup lang="ts">
import { Combobox, ComboboxAnchor, ComboboxEmpty, ComboboxGroup, ComboboxInput, ComboboxItem, ComboboxItemIndicator, ComboboxList } from '@/components/ui/combobox'
import { Check, Search } from 'lucide-vue-next'
import { ref, watch } from 'vue';
import axios from 'axios';

const search = ref('')
const results = ref([])

const fetchResults = async () => {
    if (!search.value) {
        results.value = []
        return
    }

    const response = await axios.get(route('web-api.search.index', {search: search.value}), {
        withCredentials: true,
    })

    const data = response.data

    results.value = data
}

watch(search, fetchResults, { immediate: true })
</script>

<template>
    <Combobox by="label">
        <ComboboxAnchor>
            <div class="relative w-full max-w-lg items-center">
                <ComboboxInput class="pl-9" :display-value="(val) => val?.label ?? ''" placeholder="Select framework..." v-model="search" />
                <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
          <Search class="size-4 text-muted-foreground" />
        </span>
            </div>
        </ComboboxAnchor>

        <ComboboxList>
            <ComboboxEmpty>
                No results found.
            </ComboboxEmpty>

            <ComboboxGroup>
                <ComboboxItem
                    v-for="result in results"
                    :key="result.id"
                    :value="result"
                >
                    {{ result.name }}

                    <ComboboxItemIndicator>
                        <Check class="ml-auto h-4 w-4" />
                    </ComboboxItemIndicator>
                </ComboboxItem>
            </ComboboxGroup>
        </ComboboxList>
    </Combobox>
</template>
