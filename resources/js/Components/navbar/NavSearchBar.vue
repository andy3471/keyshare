<script setup lang="ts">
import AppCombobox from '@/Components/ui/AppCombobox.vue';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import type { ComboboxItem } from '@/types/ui';

interface Props {
  id: string;
  inputClass?: string;
}

withDefaults(defineProps<Props>(), {
  inputClass: 'w-full pl-10 pr-4 py-2 bg-dark-800 border border-dark-600 text-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500',
});

const emit = defineEmits<{
  select: [item: ComboboxItem];
  search: [query: string];
}>();

const handleSelect = (item: ComboboxItem | null) => {
  if (item) emit('select', item);
};
</script>

<template>
  <div class="relative">
    <AppCombobox
      :id="id"
      name="search"
      placeholder="Search games..."
      url="/autocomplete"
      :input-class="inputClass"
      @update:model-value="handleSelect"
      @search="emit('search', $event)"
    />
    <MagnifyingGlassIcon class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400 pointer-events-none" />
  </div>
</template>
