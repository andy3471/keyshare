<script setup lang="ts">
interface Props {
  karma: number;
  karmaColour: string;
  size?: 'sm' | 'md' | 'lg';
  tooltipPosition?: 'above' | 'below';
}

withDefaults(defineProps<Props>(), {
  size: 'sm',
  tooltipPosition: 'above',
});

const sizeClasses: Record<string, string> = {
  sm: 'px-2 py-0.5 text-xs',
  md: 'px-3 py-1 text-xs',
  lg: 'px-4 py-2 text-lg font-bold',
};
</script>

<template>
  <span class="relative group/karma inline-flex">
    <span
      class="inline-flex items-center rounded-full font-semibold shadow-md cursor-help"
      :class="[karmaColour, sizeClasses[size]]"
    >
      {{ karma }}
    </span>
    <span
      class="pointer-events-none absolute left-1/2 -translate-x-1/2 w-48 rounded-lg bg-dark-800 border border-dark-600 px-3 py-2 text-xs text-gray-300 text-center shadow-xl opacity-0 group-hover/karma:opacity-100 transition-opacity duration-150 z-50"
      :class="tooltipPosition === 'below' ? 'top-full mt-2' : 'bottom-full mb-2'"
    >
      <span
        v-if="tooltipPosition === 'below'"
        class="absolute bottom-full left-1/2 -translate-x-1/2 mb-px border-4 border-transparent border-b-dark-600"
      />
      <span class="font-semibold text-white">Karma: {{ karma }}</span>
      <br>
      Earned by sharing keys and receiving positive feedback
      <span
        v-if="tooltipPosition === 'above'"
        class="absolute top-full left-1/2 -translate-x-1/2 -mt-px border-4 border-transparent border-t-dark-600"
      />
    </span>
  </span>
</template>
