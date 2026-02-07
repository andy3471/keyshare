<script setup lang="ts">
import Navbar from '@/Components/Navbar.vue';
import TitleHeader from '@/Components/TitleHeader.vue';
import FlashMessages from '@/Components/FlashMessages.vue';

interface Props {
  title?: string;
}

defineProps<Props>();
</script>

<template>
  <div class="min-h-screen bg-dark-950">
    <Navbar />

    <TitleHeader
      v-if="title"
      :title="title"
    />

    <FlashMessages />

    <main class="mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12 max-w-7xl">
      <slot />
    </main>
  </div>
</template>
