<template>
  <div
    class="border-b-2 border-dark-700 mx-4 mt-0 mb-6 h-auto text-center py-6 text-3xl sm:text-4xl font-display font-bold bg-gradient-to-r from-transparent via-accent-600/10 to-transparent"
    style="text-shadow: 0 0 20px rgba(217, 70, 239, 0.3);"
  >
    {{ title }}
  </div>
</template>

<script setup lang="ts">
interface Props {
  title: string;
}

defineProps<Props>();
</script>
