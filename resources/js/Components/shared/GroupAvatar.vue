<script setup lang="ts">
interface Props {
  avatar?: string | null;
  name: string;
  size?: 'xs' | 'sm' | 'md' | 'lg' | 'xl';
}

withDefaults(defineProps<Props>(), {
  avatar: null,
  size: 'sm',
});

const sizeClasses: Record<string, string> = {
  xs: 'w-4 h-4 rounded text-[8px]',
  sm: 'w-5 h-5 rounded text-[10px]',
  md: 'w-10 h-10 rounded-lg text-sm',
  lg: 'w-16 h-16 rounded-xl text-2xl',
  xl: 'w-28 h-28 rounded-2xl text-4xl',
};
</script>

<template>
  <img
    v-if="avatar"
    :src="avatar"
    :alt="name"
    class="object-cover flex-shrink-0"
    :class="sizeClasses[size]"
  >
  <span
    v-else
    class="bg-accent-600/20 flex items-center justify-center flex-shrink-0"
    :class="sizeClasses[size]"
  >
    <span class="text-accent-400 font-bold">{{ name.charAt(0).toUpperCase() }}</span>
  </span>
</template>
