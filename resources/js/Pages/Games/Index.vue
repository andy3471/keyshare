<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import GameList from '@/Components/games/GameList.vue';
import GameFilters from '@/Components/games/GameFilters.vue';
import { GameData, PlatformData } from '@/Types/generated';
import type { Paginated } from '@/types/global';

interface Props {
  title: string;
  games: Paginated<GameData>;
  platforms: PlatformData[];
  selectedPlatforms?: string[];
}

const props = defineProps<Props>();

const selectedPlatforms = props.selectedPlatforms ?? [];
</script>

<template>
  <AppLayout :title="title">
    <Head :title="title" />
    <GameFilters
      :platforms="platforms"
      :selected-platforms="selectedPlatforms"
    />
    <GameList :games="games" />
  </AppLayout>
</template>
