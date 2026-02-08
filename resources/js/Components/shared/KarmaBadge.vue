<script setup lang="ts">
interface Props {
  karma: number;
  karmaColour: string;
  size?: 'sm' | 'md';
}

withDefaults(defineProps<Props>(), {
  size: 'sm',
});
</script>

<template>
  <span
    class="inline-flex items-center rounded-full font-semibold shadow-md"
    :class="[
      karmaColour,
      size === 'sm' ? 'px-2 py-0.5 text-xs' : 'px-3 py-1 text-xs',
    ]"
  >
    {{ karma }}
  </span>
</template>
