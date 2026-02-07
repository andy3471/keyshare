<template>
  <AppLayout title="Shared Keys">
    <GameList :games="games" />
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import GameList from '@/Components/GameList.vue';

interface Props {
  games: {
    data: { id: number; name: string; image?: string; url: string; hasKey?: boolean; keyCount?: number }[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
}

defineProps<Props>();
</script>
