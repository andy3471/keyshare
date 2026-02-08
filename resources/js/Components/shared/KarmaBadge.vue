<script setup lang="ts">
interface Props {
  karma: number;
  karmaColour: string;
  size?: 'sm' | 'md' | 'lg';
}

withDefaults(defineProps<Props>(), {
  size: 'sm',
});

const sizeClasses: Record<string, string> = {
  sm: 'px-2 py-0.5 text-xs',
  md: 'px-3 py-1 text-xs',
  lg: 'px-4 py-2 text-lg font-bold',
};
</script>

<template>
  <span
    class="inline-flex items-center rounded-full font-semibold shadow-md"
    :class="[karmaColour, sizeClasses[size]]"
  >
    {{ karma }}
  </span>
</template>
