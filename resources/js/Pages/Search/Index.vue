<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import GameList from '@/Components/GameList.vue';
import { GameData } from '@/Types/generated';
import type { Paginated } from '@/types/global';

interface Props {
  title: string;
  games: Paginated<GameData>;
  error?: string;
}

defineProps<Props>();
</script>

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
