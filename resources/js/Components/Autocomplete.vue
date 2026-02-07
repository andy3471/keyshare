<script setup lang="ts">
import { ref, watch, onMounted, onUnmounted } from 'vue';
import type { AutocompleteItem } from '@/types/global';

interface Props {
  id?: string;
  name?: string;
  placeholder?: string;
  url: string;
  modelValue?: string;
  inputClass?: string;
}

const props = withDefaults(defineProps<Props>(), {
  inputClass: 'border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full',
});

const emit = defineEmits<{
  'update:modelValue': [value: string];
  'select': [item: AutocompleteItem];
  'search': [query: string];
}>();

const query = ref(props.modelValue ?? '');
const results = ref<AutocompleteItem[]>([]);
const loading = ref(false);
const showResults = ref(false);
const selectedIndex = ref(-1);
const containerRef = ref<HTMLElement | null>(null);
const inputRef = ref<HTMLInputElement | null>(null);
let debounceTimer: ReturnType<typeof setTimeout> | null = null;
let abortController: AbortController | null = null;

watch(() => props.modelValue, (newValue) => {
  query.value = newValue ?? '';
});

const handleInput = () => {
  emit('update:modelValue', query.value);

  // Clear previous debounce timer
  if (debounceTimer) {
    clearTimeout(debounceTimer);
  }

  // Cancel previous request
  if (abortController) {
    abortController.abort();
  }

  if (!query.value || query.value.length < 2) {
    results.value = [];
    showResults.value = false;
    loading.value = false;
    return;
  }

  // Debounce the API call
  debounceTimer = setTimeout(() => {
    void fetchResults();
  }, 300); // 300ms debounce
};

const handleFocus = () => {
  if (results.value.length > 0) {
    showResults.value = true;
  }
};

const fetchResults = async () => {
  if (!query.value || query.value.length < 2) {
    return;
  }

  loading.value = true;
  showResults.value = true;

  // Create new abort controller for this request
  abortController = new AbortController();

  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
    const response = await fetch(`${props.url}?q=${encodeURIComponent(query.value)}`, {
      signal: abortController.signal,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        Accept: 'application/json',
        'X-CSRF-TOKEN': csrfToken,
      },
      credentials: 'same-origin',
    });

    if (response.ok) {
      const data = (await response.json()) as AutocompleteItem[];
      results.value = Array.isArray(data) ? data : [];
      showResults.value = results.value.length > 0 || query.value.length >= 2;
      selectedIndex.value = -1;
    } else {
      results.value = [];
      showResults.value = false;
    }
  } catch (error: unknown) {
    // Ignore abort errors
    if (error instanceof DOMException && error.name === 'AbortError') {
      return;
    }
    console.error('Autocomplete error:', error);
    results.value = [];
    showResults.value = false;
  } finally {
    loading.value = false;
    abortController = null;
  }
};

const select = (item: AutocompleteItem) => {
  query.value = item.name;
  emit('update:modelValue', query.value);
  emit('select', item);
  showResults.value = false;
  selectedIndex.value = -1;
  results.value = [];
};

const navigateDown = () => {
  if (selectedIndex.value < results.value.length - 1) {
    selectedIndex.value++;
    scrollToSelected();
  }
};

const navigateUp = () => {
  if (selectedIndex.value > 0) {
    selectedIndex.value--;
    scrollToSelected();
  }
};

const scrollToSelected = () => {
  // Scroll the selected item into view
  const dropdown = containerRef.value?.querySelector('.max-h-60');
  if (dropdown != null && selectedIndex.value >= 0) {
    const selectedElement = dropdown.children[selectedIndex.value] as HTMLElement | undefined;
    selectedElement?.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
  }
};

const selectCurrent = () => {
  if (selectedIndex.value >= 0 && results.value[selectedIndex.value]) {
    select(results.value[selectedIndex.value]);
  } else if (results.value.length === 1) {
    // If only one result, select it
    select(results.value[0]);
  }
};

const handleEnter = (event: KeyboardEvent) => {
  event.preventDefault();
  event.stopPropagation();

  // Get the current value directly from the input element to ensure we have the latest value
  const inputValue = inputRef.value?.value;
  const currentValue = inputValue ?? query.value;

  // If there's a selected item in the dropdown, select it
  if (selectedIndex.value >= 0 && selectedIndex.value < results.value.length) {
    selectCurrent();
  } else {
    // Otherwise, emit search event with whatever query is in the input
    emit('search', currentValue);
    showResults.value = false;
  }
};

const closeDropdown = () => {
  showResults.value = false;
  selectedIndex.value = -1;
};

const handleClickOutside = (event: MouseEvent) => {
  if (containerRef.value && !containerRef.value.contains(event.target as Node)) {
    showResults.value = false;
    selectedIndex.value = -1;
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
  if (debounceTimer) {
    clearTimeout(debounceTimer);
  }
  if (abortController) {
    abortController.abort();
  }
});
</script>

<template>
  <div
    ref="containerRef"
    class="relative"
  >
    <div class="relative">
      <input
        :id="id"
        v-model="query"
        :name="name"
        :placeholder="placeholder"
        :class="inputClass"
        type="text"
        autocomplete="off"
        @input="handleInput"
        @focus="handleFocus"
        @keydown.down.prevent="navigateDown"
        @keydown.up.prevent="navigateUp"
        @keydown.enter.prevent="handleEnter"
        @keydown.escape="closeDropdown"
      >
      <!-- Loading Indicator -->
      <div
        v-if="loading"
        class="absolute right-3 top-1/2 transform -translate-y-1/2"
      >
        <svg
          class="animate-spin h-5 w-5 text-accent-400"
          fill="none"
          viewBox="0 0 24 24"
        >
          <circle
            class="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"
          />
          <path
            class="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
          />
        </svg>
      </div>
    </div>

    <!-- Dropdown Results -->
    <Transition
      enter-active-class="transition ease-out duration-100"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div
        v-if="showResults && results.length > 0"
        class="absolute z-50 w-full mt-2 bg-dark-800 border border-dark-600 rounded-lg overflow-hidden shadow-xl"
      >
        <div class="max-h-60 overflow-auto">
          <div
            v-for="(result, index) in results"
            :key="index"
            :class="[
              'px-4 py-3 cursor-pointer transition-colors',
              index === selectedIndex
                ? 'bg-accent-600 text-white'
                : 'text-gray-300 hover:bg-dark-700 hover:text-white'
            ]"
            @click="select(result)"
            @mouseenter="selectedIndex = index"
          >
            <div class="font-medium">
              {{ result.name || result }}
            </div>
          </div>
        </div>
      </div>
    </Transition>

    <!-- No Results Message -->
    <Transition
      enter-active-class="transition ease-out duration-100"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="showResults && !loading && query.length >= 2 && results.length === 0"
        class="absolute z-50 w-full mt-2 bg-dark-800 border border-dark-600 rounded-lg p-4 shadow-xl"
      >
        <p class="text-gray-400 text-sm text-center">
          No games found. Try a different search term.
        </p>
      </div>
    </Transition>
  </div>
</template>
