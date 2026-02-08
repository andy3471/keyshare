<script setup lang="ts">
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue';

interface Props {
  align?: 'left' | 'right';
  width?: string;
}

withDefaults(defineProps<Props>(), {
  align: 'left',
  width: 'w-full',
});
</script>

<template>
  <Popover class="relative">
    <PopoverButton as="template">
      <slot name="trigger" />
    </PopoverButton>

    <transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 translate-y-1"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 translate-y-1"
    >
      <PopoverPanel
        class="absolute z-50 mt-2 bg-dark-800 border border-dark-700 rounded-lg shadow-xl max-h-64 overflow-y-auto"
        :class="[width, align === 'right' ? 'right-0' : 'left-0']"
      >
        <slot />
      </PopoverPanel>
    </transition>
  </Popover>
</template>
