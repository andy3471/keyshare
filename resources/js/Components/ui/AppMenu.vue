<script setup lang="ts">
import { Menu, MenuButton, MenuItems } from '@headlessui/vue';

interface Props {
  align?: 'left' | 'right';
  width?: string;
}

withDefaults(defineProps<Props>(), {
  align: 'right',
  width: 'w-56',
});
</script>

<template>
  <Menu
    as="div"
    class="relative"
  >
    <MenuButton as="template">
      <slot name="trigger" />
    </MenuButton>

    <transition
      enter-active-class="transition ease-out duration-100"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <MenuItems
        class="absolute mt-2 bg-dark-800 rounded-lg shadow-xl border border-dark-700 overflow-hidden z-50 focus:outline-none"
        :class="[width, align === 'right' ? 'right-0' : 'left-0']"
      >
        <div class="py-1">
          <slot />
        </div>
      </MenuItems>
    </transition>
  </Menu>
</template>
