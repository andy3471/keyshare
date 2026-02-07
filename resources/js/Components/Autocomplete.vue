<template>
    <div class="relative" @blur="hideResults">
        <input
            :id="id"
            v-model="query"
            :name="name"
            :placeholder="placeholder"
            :class="inputClass"
            type="text"
            autocomplete="off"
            @input="handleInput"
            @focus="showResults = results.length > 0"
            @keydown.down.prevent="navigateDown"
            @keydown.up.prevent="navigateUp"
            @keydown.enter.prevent="selectCurrent"
        />
        <div
            v-if="showResults && results.length > 0"
            class="absolute z-50 w-full mt-1 bg-dark-800 border border-dark-600 rounded-b-lg overflow-auto max-h-60 shadow-lg"
        >
            <div
                v-for="(result, index) in results"
                :key="index"
                :class="[
                    'list-none text-left p-2 cursor-pointer hover:bg-accent-600 hover:text-white transition-colors',
                    { 'bg-accent-600 text-white': index === selectedIndex }
                ]"
                @click="select(result)"
                @mouseenter="selectedIndex = index"
            >
                {{ result.name || result }}
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';

interface Props {
    id?: string;
    name?: string;
    placeholder?: string;
    url: string;
    modelValue?: string;
    inputClass?: string;
}

const props = withDefaults(defineProps<Props>(), {
    inputClass: 'border border-dark-600 rounded-lg bg-dark-800 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full',
});

const emit = defineEmits<{
    'update:modelValue': [value: string];
    'select': [item: any];
}>();

const query = ref(props.modelValue || '');
const results = ref<any[]>([]);
const loading = ref(false);
const showResults = ref(false);
const selectedIndex = ref(-1);

watch(() => props.modelValue, (newValue) => {
    query.value = newValue || '';
});

const handleInput = async () => {
    emit('update:modelValue', query.value);
    
    if (!query.value || query.value.length < 2) {
        results.value = [];
        showResults.value = false;
        return;
    }

    loading.value = true;
    try {
        // Use fetch for lightweight autocomplete requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const response = await fetch(`${props.url}?q=${encodeURIComponent(query.value)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            credentials: 'same-origin',
        });
        
        if (response.ok) {
            const data = await response.json();
            results.value = data;
            showResults.value = results.value.length > 0;
            selectedIndex.value = -1;
        } else {
            results.value = [];
            showResults.value = false;
        }
    } catch (error) {
        console.error('Autocomplete error:', error);
        results.value = [];
        showResults.value = false;
    } finally {
        loading.value = false;
    }
};

const select = (item: any) => {
    query.value = item.name || item;
    emit('update:modelValue', query.value);
    emit('select', item);
    showResults.value = false;
    selectedIndex.value = -1;
};

const navigateDown = () => {
    if (selectedIndex.value < results.value.length - 1) {
        selectedIndex.value++;
    }
};

const navigateUp = () => {
    if (selectedIndex.value > 0) {
        selectedIndex.value--;
    }
};

const selectCurrent = () => {
    if (selectedIndex.value >= 0 && results.value[selectedIndex.value]) {
        select(results.value[selectedIndex.value]);
    }
};

const hideResults = () => {
    setTimeout(() => {
        showResults.value = false;
    }, 200);
};
</script>
