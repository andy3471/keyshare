<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import GameList from '@/Components/GameList.vue';
import GameFilters from '@/Components/GameFilters.vue';
import { GameData, PlatformData } from '@/Types/generated';
import type { Paginated } from '@/types/global';

interface Props {
  title: string;
  games: Paginated<GameData>;
  selectedPlatforms?: string[];
}

const props = defineProps<Props>();

const page = usePage();
const platforms = (page.props.platforms as PlatformData[] | undefined) ?? [];
const selectedPlatforms = props.selectedPlatforms ?? [];
</script>

<template>
  <AppLayout :title="title">
    <Head :title="title" />
    <div class="max-w-7xl mx-auto px-4 py-6">
      <GameFilters
        :platforms="platforms"
        :selected-platforms="selectedPlatforms"
      />
      <GameList :games="games" />
    </div>
  </AppLayout>
</template>
