<script setup lang="ts">
import { MenuItem } from '@headlessui/vue';

interface Props {
  as?: string;
  disabled?: boolean;
}

withDefaults(defineProps<Props>(), {
  as: 'button',
  disabled: false,
});
</script>

<template>
  <MenuItem
    v-slot="{ active }"
    :disabled="disabled"
  >
    <component
      :is="as"
      class="block w-full text-left px-4 py-2 text-sm transition-colors"
      :class="[
        active ? 'bg-accent-600 text-white' : 'text-gray-300',
        disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
      ]"
    >
      <slot :active="active" />
    </component>
  </MenuItem>
</template>
