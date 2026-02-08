<script setup lang="ts">
import { InfiniteScroll, Link } from '@inertiajs/vue3';
import GameCard from '@/Components/shared/GameCard.vue';
import EmptyState from '@/Components/shared/EmptyState.vue';
import { GameData } from '@/Types/generated';
import type { Paginated } from '@/types/global';
import { FaceFrownIcon, PlusIcon } from '@heroicons/vue/24/outline';
import { create as createKeyRoute } from '@/routes/keys';

interface Props {
  games?: Paginated<GameData>;
  scrollProp?: string;
}

const props = withDefaults(defineProps<Props>(), {
  games: () => ({
    data: [],
    current_page: 1,
    last_page: 1,
    per_page: 12,
    total: 0,
  }),
  scrollProp: 'games',
});
</script>

<template>
  <InfiniteScroll
    v-if="games && games.data"
    :data="props.scrollProp"
    preserve-url
  >
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6 mt-6">
      <GameCard
        v-for="game in games.data"
        :key="game.id"
        :game="game"
      />
    </div>

    <EmptyState
      v-if="games.data.length === 0"
      title="No Games Found"
      message="Try adjusting your search or filters, or add a key to get started."
    >
      <template #icon>
        <FaceFrownIcon class="w-24 h-24 text-gray-600" />
      </template>
      <template #action>
        <Link
          :href="createKeyRoute.url()"
          class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-accent-600 hover:bg-accent-500 text-white text-sm font-medium rounded-lg transition-colors"
        >
          <PlusIcon class="w-4 h-4" />
          Add a Key
        </Link>
      </template>
    </EmptyState>
  </InfiniteScroll>

  <div
    v-else
    class="col-span-full"
  >
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
      <div
        v-for="i in 12"
        :key="i"
        class="relative w-full bg-dark-700 rounded-lg animate-pulse"
        style="aspect-ratio: 3/4;"
      />
    </div>
  </div>
</template>
