<script setup lang="ts">
import Navbar from '@/Components/Navbar.vue';
import TitleHeader from '@/Components/TitleHeader.vue';
import FlashMessages from '@/Components/FlashMessages.vue';
import AppFooter from '@/Components/AppFooter.vue';

interface Props {
  title?: string;
}

defineProps<Props>();
</script>

<template>
  <div class="min-h-screen flex flex-col bg-dark-950">
    <Navbar />

    <TitleHeader
      v-if="title"
      :title="title"
    />

    <FlashMessages />

    <main class="flex-1 mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12 max-w-7xl w-full">
      <slot />
    </main>

    <AppFooter />
  </div>
</template>
