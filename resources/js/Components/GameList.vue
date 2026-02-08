<script setup lang="ts">
import { Link, InfiniteScroll } from '@inertiajs/vue3';
import KeyAvailabilityBadge from './KeyAvailabilityBadge.vue';
import gamesRoute from '@/routes/games';
import { GameData } from '@/Types/generated';
import type { Paginated } from '@/types/global';

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
      <div
        v-for="game in games.data"
        :key="game.id"
        class="game-card group relative min-w-0"
        :class="{ 'has-keys': game.keyCount !== undefined && game.keyCount > 0 }"
      >
        <Link
          :href="gamesRoute.show.url(game.id)"
          class="block w-full h-full relative"
        >
          <KeyAvailabilityBadge
            v-if="game.keyCount !== undefined"
            :key-count="game.keyCount || 0"
          />
          <img
            v-if="game.image"
            :src="game.image"
            :alt="game.name"
            class="game-image"
          >
          <div
            v-else
            class="game-image-placeholder flex items-center justify-center"
          >
            <svg
              class="w-10 h-10 text-dark-500"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.5"
                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"
              />
            </svg>
          </div>
          <div class="game-overlay">
            {{ game.name }}
          </div>
        </Link>
      </div>
    </div>
    <div
      v-if="games.data.length === 0"
      class="col-span-full text-center py-12"
    >
      <div class="inline-flex flex-col items-center space-y-4">
        <svg
          class="w-24 h-24 text-gray-600"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1.5"
            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
        <p class="text-xl font-medium text-gray-400">
          No Games Found
        </p>
        <p class="text-sm text-gray-500">
          Try adjusting your search or filters
        </p>
      </div>
    </div>
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

<style scoped>
.game-card {
    @apply relative w-full bg-dark-800 rounded-lg border border-dark-700 flex justify-center items-center transition-all duration-300 overflow-hidden;
    @apply hover:border-accent-500 hover:shadow-xl hover:shadow-accent-500/30 hover:-translate-y-1;
    aspect-ratio: 3 / 4;
}

.game-card.has-keys {
    @apply border-green-500/50;
}

.game-card.has-keys:hover {
    @apply border-green-500 shadow-green-500/30;
}

.game-card:hover .game-overlay {
    @apply opacity-100 translate-y-0;
    min-height: 50%;
}

.game-card:hover .game-image {
    @apply scale-110;
}

.game-image {
    @apply block w-full h-full object-cover rounded-lg transition-transform duration-500;
}

.game-image-placeholder {
    @apply min-h-full relative w-full bg-dark-800;
}

.game-overlay {
    @apply absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 via-black/80 to-transparent text-white transition-all duration-300 opacity-90 translate-y-0 text-sm font-medium text-center px-3 py-4 flex items-end justify-center rounded-b-lg break-words overflow-hidden;
    min-height: 40%;
}
</style>
