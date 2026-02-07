<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import GameList from '@/Components/GameList.vue';
import { GameData, PlatformData } from '@/Types/generated';
import type { Paginated } from '@/types/global';

interface Props {
  platform: PlatformData;
  games: Paginated<GameData>;
}

defineProps<Props>();
</script>

<template>
  <AppLayout :title="platform.name">
    <GameList :games="games" />
  </AppLayout>
</template>
