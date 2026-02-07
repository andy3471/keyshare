<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import GameList from '@/Components/GameList.vue';
import { GameData } from '@/Types/generated';
import type { Paginated } from '@/types/global';

interface Props {
  games: Paginated<GameData>;
}

defineProps<Props>();
</script>

<template>
  <AppLayout title="Claimed Keys">
    <GameList :games="games" />
  </AppLayout>
</template>
