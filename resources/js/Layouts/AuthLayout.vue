<script setup lang="ts">
import AppFooter from '@/Components/AppFooter.vue';
</script>

<template>
  <div class="min-h-screen flex flex-col bg-dark-950">
    <div class="flex-1 flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div class="w-full max-w-md">
        <div class="bg-dark-800 rounded-lg shadow-xl p-8 border border-dark-700">
          <slot />
        </div>
      </div>
    </div>

    <AppFooter />
  </div>
</template>
