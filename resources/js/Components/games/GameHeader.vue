<script setup lang="ts">
import GameImagePlaceholder from '@/Components/shared/GameImagePlaceholder.vue';
import { GameData } from '@/Types/generated';
import { StarIcon } from '@heroicons/vue/24/solid';

interface Props {
  game: GameData;
}

defineProps<Props>();
</script>

<template>
  <div class="flex flex-col lg:flex-row gap-6 mb-8">
    <div class="flex-shrink-0">
      <div class="w-[180px]">
        <img
          v-if="game.image"
          :src="game.image"
          :alt="game.name"
          class="w-full rounded-lg border border-dark-700 object-cover aspect-[2/3]"
        >
        <div
          v-else
          class="w-full aspect-[2/3]"
        >
          <GameImagePlaceholder size="lg" />
        </div>
      </div>
    </div>

    <div class="flex-1 bg-dark-800 rounded-lg border border-dark-700 p-6 h-fit">
      <div
        v-if="game.genres && game.genres.length > 0"
        class="mb-4"
      >
        <span
          v-for="genre in game.genres"
          :key="genre.id"
          class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold shadow-md bg-primary-600 text-white shadow-primary-600/30 mr-2 mb-2"
        >
          {{ genre.name }}
        </span>
      </div>

      <div
        v-if="game?.aggregated_rating"
        class="mb-4 text-gray-300"
      >
        <div class="flex items-center space-x-2">
          <StarIcon class="w-5 h-5 text-yellow-400" />
          <span class="font-semibold">{{ game.aggregated_rating }}</span>
          <span class="text-gray-500">({{ game.aggregated_rating_count }} reviews)</span>
        </div>
      </div>

      <div
        v-if="game.description"
        class="text-gray-300 leading-relaxed"
      >
        <h3 class="text-lg font-semibold text-white mb-2">
          Description
        </h3>
        <p class="text-sm">
          {{ game.description }}
        </p>
      </div>
      <div
        v-else
        class="text-gray-500 text-sm italic"
      >
        No description available
      </div>
    </div>
  </div>
</template>
