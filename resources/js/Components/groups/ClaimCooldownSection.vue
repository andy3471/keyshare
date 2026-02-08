<script setup lang="ts">
import FormInput from '@/Components/ui/FormInput.vue';
import { ClockIcon } from '@heroicons/vue/24/outline';

interface Props {
  modelValue: number | string | null;
  error?: string;
}

defineProps<Props>();

const emit = defineEmits<{
  'update:modelValue': [value: string | number | null];
}>();
</script>

<template>
  <div class="border-t border-dark-700 pt-6">
    <div class="flex items-center gap-3 mb-4">
      <ClockIcon class="w-5 h-5 text-primary-400" />
      <h3 class="text-sm font-semibold text-white">
        Claim Cooldown
      </h3>
    </div>
    <FormInput
      id="claim_cooldown_minutes"
      :model-value="modelValue"
      label="Cooldown between claims (minutes)"
      type="number"
      placeholder="No cooldown"
      :error="error"
      hint="After claiming a key, members must wait this many minutes before claiming another in this group. Leave empty for no restriction."
      @update:model-value="emit('update:modelValue', $event)"
    >
      <template #label-suffix>
        <span class="text-gray-500"> (optional)</span>
      </template>
    </FormInput>
  </div>
</template>
