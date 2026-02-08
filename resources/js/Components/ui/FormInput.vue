<script setup lang="ts">
interface Props {
  id: string;
  label?: string;
  type?: string;
  modelValue: string | number;
  error?: string;
  hint?: string;
  required?: boolean;
  disabled?: boolean;
  placeholder?: string;
  autocomplete?: string;
  inputClass?: string;
}

withDefaults(defineProps<Props>(), {
  label: '',
  type: 'text',
  error: '',
  hint: '',
  required: false,
  disabled: false,
  placeholder: '',
  autocomplete: '',
  inputClass: '',
});

const emit = defineEmits<{
  'update:modelValue': [value: string | number];
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

    <div class="relative">
      <slot name="prefix" />
      <input
        :id="id"
        :type="type"
        :value="modelValue"
        :placeholder="placeholder"
        :required="required"
        :disabled="disabled"
        :autocomplete="autocomplete"
        class="w-full bg-dark-900 border border-dark-600 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:border-accent-500 focus:ring-1 focus:ring-accent-500 transition-colors disabled:opacity-60 disabled:cursor-not-allowed"
        :class="[
          error ? 'border-danger focus:ring-danger' : '',
          inputClass,
        ]"
        @input="emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      >
      <slot name="suffix" />
    </div>

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
