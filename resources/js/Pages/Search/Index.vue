<template>
  <AppLayout :title="title">
    <div class="max-w-7xl mx-auto px-4 py-6">
      <div
        v-if="error"
        class="mb-6 bg-red-900/50 border border-red-700 rounded-lg p-4 text-red-300"
      >
        {{ error }}
      </div>
      <GameList :games="games" />
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import GameList from '@/Components/GameList.vue';

interface Props {
  title: string;
  games: {
    data: { id: number; name: string; image?: string; url: string; hasKey?: boolean; keyCount?: number }[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
  error?: string;
}

defineProps<Props>();
</script>
