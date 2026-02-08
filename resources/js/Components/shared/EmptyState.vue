<script setup lang="ts">
interface Props {
  title: string;
  message?: string;
}

withDefaults(defineProps<Props>(), {
  message: '',
});
</script>

<template>
  <div class="bg-dark-800 rounded-lg border border-dark-700 p-12 text-center">
    <div class="inline-flex flex-col items-center space-y-4">
      <slot name="icon" />
      <div>
        <p class="text-xl font-medium text-gray-300">
          {{ title }}
        </p>
        <p
          v-if="message"
          class="text-sm text-gray-500 mt-1"
        >
          {{ message }}
        </p>
        <slot name="action" />
      </div>
    </div>
  </div>
</template>
