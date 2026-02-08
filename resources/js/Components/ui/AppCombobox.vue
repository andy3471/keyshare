<script setup lang="ts">
import { ref, watch, onUnmounted } from 'vue';
import {
  Combobox,
  ComboboxInput,
  ComboboxOptions,
  ComboboxOption,
} from '@headlessui/vue';
import type { ComboboxItem } from '@/types/ui';

interface Props {
  id?: string;
  name?: string;
  placeholder?: string;
  url: string;
  modelValue?: ComboboxItem | null;
  inputClass?: string;
}

const props = withDefaults(defineProps<Props>(), {
  id: '',
  name: '',
  placeholder: '',
  modelValue: null,
  inputClass: 'border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full',
});

const emit = defineEmits<{
  'update:modelValue': [value: ComboboxItem | null];
  'search': [query: string];
}>();

const query = ref(props.modelValue?.name ?? '');
const results = ref<ComboboxItem[]>([]);
const loading = ref(false);
let debounceTimer: ReturnType<typeof setTimeout> | null = null;
let abortController: AbortController | null = null;

watch(() => props.modelValue, (newValue) => {
  query.value = newValue?.name ?? '';
});

const fetchResults = async (searchQuery: string) => {
  if (!searchQuery || searchQuery.length < 2) {
    results.value = [];
    loading.value = false;
    return;
  }

  if (abortController) {
    abortController.abort();
  }

  loading.value = true;
  abortController = new AbortController();

  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
    const response = await fetch(`${props.url}?q=${encodeURIComponent(searchQuery)}`, {
      signal: abortController.signal,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        Accept: 'application/json',
        'X-CSRF-TOKEN': csrfToken,
      },
      credentials: 'same-origin',
    });

    if (response.ok) {
      const data = (await response.json()) as ComboboxItem[];
      results.value = Array.isArray(data) ? data : [];
    } else {
      results.value = [];
    }
  } catch (error: unknown) {
    if (error instanceof DOMException && error.name === 'AbortError') {
      return;
    }
    results.value = [];
  } finally {
    loading.value = false;
    abortController = null;
  }
};

const handleQueryChange = (event: Event) => {
  const value = (event.target as HTMLInputElement).value;
  query.value = value;
  emit('update:modelValue', null);

  if (debounceTimer) {
    clearTimeout(debounceTimer);
  }

  debounceTimer = setTimeout(() => {
    void fetchResults(value);
  }, 300);
};

const handleSelect = (item: ComboboxItem | null) => {
  if (item) {
    query.value = item.name;
    emit('update:modelValue', item);
    results.value = [];
  }
};

const handleKeydownEnter = () => {
  if (results.value.length === 0) {
    emit('search', query.value);
  }
};

onUnmounted(() => {
  if (debounceTimer) {
    clearTimeout(debounceTimer);
  }
  if (abortController) {
    abortController.abort();
  }
});
</script>

<template>
  <Combobox
    :model-value="modelValue"
    nullable
    @update:model-value="handleSelect"
  >
    <div class="relative">
      <div class="relative">
        <ComboboxInput
          :id="id"
          :name="name"
          :placeholder="placeholder"
          :class="inputClass"
          :display-value="(item: unknown) => (item as ComboboxItem)?.name ?? query"
          autocomplete="off"
          @change="handleQueryChange"
          @keydown.enter="handleKeydownEnter"
        />
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

      <transition
        enter-active-class="transition ease-out duration-100"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
      >
        <ComboboxOptions
          v-if="results.length > 0"
          class="absolute z-50 w-full mt-2 bg-dark-800 border border-dark-600 rounded-lg overflow-hidden shadow-xl max-h-60 overflow-auto"
        >
          <ComboboxOption
            v-for="result in results"
            :key="result.id"
            v-slot="{ active }"
            :value="result"
            as="template"
          >
            <li
              class="px-4 py-3 cursor-pointer transition-colors"
              :class="active ? 'bg-accent-600 text-white' : 'text-gray-300 hover:bg-dark-700 hover:text-white'"
            >
              <div class="font-medium">
                {{ result.name }}
              </div>
            </li>
          </ComboboxOption>
        </ComboboxOptions>
      </transition>

      <transition
        enter-active-class="transition ease-out duration-100"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition ease-in duration-75"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          v-if="!loading && query.length >= 2 && results.length === 0 && !modelValue"
          class="absolute z-50 w-full mt-2 bg-dark-800 border border-dark-600 rounded-lg p-4 shadow-xl"
        >
          <p class="text-gray-400 text-sm text-center">
            No games found. Try a different search term.
          </p>
        </div>
      </transition>
    </div>
  </Combobox>
</template>
