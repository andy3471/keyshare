<script setup lang="ts">
import FormInput from '@/Components/ui/FormInput.vue';
import { BoltIcon } from '@heroicons/vue/24/outline';

interface Props {
  modelValue: number | string;
  error?: string;
}

defineProps<Props>();

const emit = defineEmits<{
  'update:modelValue': [value: string | number];
}>();
</script>

<template>
  <div class="border-t border-dark-700 pt-6">
    <div class="flex items-center gap-3 mb-4">
      <BoltIcon class="w-5 h-5 text-warning" />
      <h3 class="text-sm font-semibold text-white">
        Karma Requirement
      </h3>
    </div>
    <FormInput
      id="min_karma"
      :model-value="modelValue"
      label="Minimum karma to claim keys"
      type="number"
      placeholder="No minimum"
      :error="error"
      hint="Members with karma below this threshold won't be able to claim keys in this group. Leave empty for no restriction."
      @update:model-value="emit('update:modelValue', $event)"
    >
      <template #label-suffix>
        <span class="text-gray-500"> (optional)</span>
      </template>
    </FormInput>
  </div>
</template>
