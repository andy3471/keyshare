<script setup lang="ts">
import { TicketIcon } from '@heroicons/vue/24/outline';

interface Props {
  size?: 'sm' | 'md' | 'lg';
}

withDefaults(defineProps<Props>(), {
  size: 'md',
});

const sizeClasses: Record<string, string> = {
  sm: 'w-6 h-6',
  md: 'w-10 h-10',
  lg: 'w-16 h-16',
};
</script>

<template>
  <div class="w-full h-full min-h-[80px] flex items-center justify-center bg-gradient-to-br from-dark-800 via-dark-700 to-dark-800 border border-dark-700 rounded-lg">
    <TicketIcon
      class="text-accent-500/50"
      :class="sizeClasses[size]"
    />
  </div>
</template>
