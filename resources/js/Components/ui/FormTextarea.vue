<script setup lang="ts">
interface Props {
  id: string;
  label?: string;
  modelValue: string;
  error?: string;
  hint?: string;
  required?: boolean;
  placeholder?: string;
  rows?: number;
  maxlength?: number;
}

withDefaults(defineProps<Props>(), {
  label: '',
  error: '',
  hint: '',
  required: false,
  placeholder: '',
  rows: 3,
  maxlength: undefined,
});

const emit = defineEmits<{
  'update:modelValue': [value: string];
}>();
</script>

<template>
  <div>
    <label
      v-if="label"
      :for="id"
      class="block text-sm font-medium text-gray-300 mb-2"
    >
      {{ label }}
      <span
        v-if="required"
        class="text-red-400"
      >*</span>
      <slot name="label-suffix" />
    </label>

    <textarea
      :id="id"
      :value="modelValue"
      :rows="rows"
      :placeholder="placeholder"
      :required="required"
      :maxlength="maxlength"
      class="w-full bg-dark-900 border border-dark-600 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:border-accent-500 focus:ring-1 focus:ring-accent-500 transition-colors resize-none"
      :class="error ? 'border-danger focus:ring-danger' : ''"
      @input="emit('update:modelValue', ($event.target as HTMLTextAreaElement).value)"
    />

    <p
      v-if="hint && !error"
      class="mt-1.5 text-xs text-gray-500"
    >
      {{ hint }}
    </p>
    <p
      v-if="error"
      class="mt-1 text-sm text-danger-400"
    >
      {{ error }}
    </p>
  </div>
</template>
