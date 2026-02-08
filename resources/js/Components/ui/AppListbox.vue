<script setup lang="ts">
import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from '@headlessui/vue';
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid';
import type { ListboxOptionItem } from '@/types/ui';

interface Props {
  modelValue: string;
  options: ListboxOptionItem[];
  label?: string;
  placeholder?: string;
  error?: string;
  hint?: string;
  required?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  label: '',
  placeholder: 'Select an option',
  error: '',
  hint: '',
  required: false,
});

const emit = defineEmits<{
  'update:modelValue': [value: string];
}>();

const selectedOption = () => {
  return props.options.find(o => o.id === props.modelValue);
};
</script>

<template>
  <div>
    <label
      v-if="label"
      class="block text-sm font-medium text-gray-300 mb-2"
    >
      {{ label }}
      <span
        v-if="required"
        class="text-red-400"
      >*</span>
    </label>

    <Listbox
      :model-value="modelValue"
      @update:model-value="emit('update:modelValue', $event)"
    >
      <div class="relative">
        <ListboxButton class="relative w-full cursor-pointer border border-dark-600 rounded-lg bg-dark-900 text-left px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200">
          <span
            :class="selectedOption() ? 'text-gray-100' : 'text-gray-500'"
            class="flex items-center gap-2 truncate"
          >
            <slot
              v-if="selectedOption()"
              name="selected"
              :option="selectedOption()!"
            >
              {{ selectedOption()?.name }}
            </slot>
            <template v-else>
              {{ placeholder }}
            </template>
          </span>
          <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <ChevronUpDownIcon class="h-5 w-5 text-gray-400" />
          </span>
        </ListboxButton>

        <transition
          leave-active-class="transition ease-in duration-100"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <ListboxOptions class="absolute z-50 mt-2 w-full max-h-60 overflow-auto rounded-lg bg-dark-800 border border-dark-600 shadow-xl focus:outline-none">
            <ListboxOption
              v-for="option in options"
              :key="option.id"
              v-slot="{ active, selected }"
              :value="option.id"
              as="template"
            >
              <li
                class="relative cursor-pointer select-none px-4 py-3 transition-colors"
                :class="active ? 'bg-accent-600 text-white' : 'text-gray-300'"
              >
                <span
                  class="flex items-center gap-2 truncate"
                  :class="selected ? 'font-semibold' : 'font-normal'"
                >
                  <slot
                    name="option"
                    :option="option"
                  >
                    {{ option.name }}
                  </slot>
                </span>
                <span
                  v-if="selected"
                  class="absolute inset-y-0 right-0 flex items-center pr-3"
                  :class="active ? 'text-white' : 'text-accent-400'"
                >
                  <CheckIcon class="h-5 w-5" />
                </span>
              </li>
            </ListboxOption>
          </ListboxOptions>
        </transition>
      </div>
    </Listbox>

    <p
      v-if="hint && !error"
      class="mt-2 text-xs text-gray-500"
    >
      {{ hint }}
    </p>
    <p
      v-if="error"
      class="mt-2 text-sm text-red-400"
    >
      {{ error }}
    </p>
  </div>
</template>
