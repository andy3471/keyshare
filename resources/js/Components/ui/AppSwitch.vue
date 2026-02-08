<script setup lang="ts">
import { Switch } from '@headlessui/vue';

interface Props {
  modelValue: boolean;
  label?: string;
  description?: string;
}

defineProps<Props>();

const emit = defineEmits<{
  'update:modelValue': [value: boolean];
}>();
</script>

<template>
  <div class="flex items-center justify-between">
    <div v-if="label || description">
      <label class="text-sm font-medium text-gray-300">
        {{ label }}
      </label>
      <p
        v-if="description"
        class="text-xs text-gray-500 mt-0.5"
      >
        {{ description }}
      </p>
    </div>
    <Switch
      :model-value="modelValue"
      class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-accent-500 focus:ring-offset-2 focus:ring-offset-dark-800"
      :class="modelValue ? 'bg-accent-600' : 'bg-dark-600'"
      @update:model-value="emit('update:modelValue', $event)"
    >
      <span
        class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
        :class="modelValue ? 'translate-x-5' : 'translate-x-0'"
      />
    </Switch>
  </div>
</template>
