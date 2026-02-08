<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import GameImagePlaceholder from '@/Components/shared/GameImagePlaceholder.vue';
import PlatformIcon from '@/Components/shared/PlatformIcon.vue';
import games from '@/routes/games';
import { GameData } from '@/Types/generated';
import { StarIcon } from '@heroicons/vue/24/solid';

interface Props {
  game: GameData;
  linkable?: boolean;
  platformName?: string;
  platformIcon?: string;
  showRating?: boolean;
  showGenres?: boolean;
}

withDefaults(defineProps<Props>(), {
  linkable: false,
  platformName: undefined,
  platformIcon: undefined,
  showRating: false,
  showGenres: false,
});
</script>

<template>
  <div class="bg-dark-800 rounded-lg border border-dark-700 p-6">
    <div class="flex flex-col lg:flex-row gap-6">
      <div class="flex-shrink-0">
        <component
          :is="linkable ? Link : 'div'"
          v-bind="linkable ? { href: games.show.url(game.id), class: 'block' } : {}"
        >
          <div class="w-[180px]">
            <img
              v-if="game.image"
              :src="game.image"
              :alt="game.name"
              class="w-full rounded-lg border border-dark-700 object-cover aspect-[2/3]"
              :class="linkable ? 'hover:border-accent-500 transition-colors' : ''"
            >
            <div
              v-else
              class="w-full aspect-[2/3]"
            >
              <GameImagePlaceholder size="lg" />
            </div>
          </div>
        </component>
      </div>

      <div class="flex-1">
        <component
          :is="linkable ? Link : 'div'"
          v-bind="linkable ? { href: games.show.url(game.id), class: 'block mb-4' } : { class: 'mb-2' }"
        >
          <h1
            class="text-3xl font-bold text-white"
            :class="linkable ? 'hover:text-accent-400 transition-colors' : ''"
          >
            {{ game.name }}
          </h1>
        </component>

        <div
          v-if="showRating && game?.aggregated_rating"
          class="flex items-center gap-2 text-gray-300 mb-3"
        >
          <StarIcon class="w-5 h-5 text-yellow-400" />
          <span class="font-semibold">{{ game.aggregated_rating }}</span>
          <span class="text-gray-500">({{ game.aggregated_rating_count }} reviews)</span>
        </div>

        <p
          v-if="game.description"
          class="text-gray-300 text-sm leading-relaxed line-clamp-4 mb-4"
        >
          {{ game.description }}
        </p>

        <div
          v-if="showGenres && game.genres && game.genres.length > 0"
          class="flex flex-wrap gap-2"
        >
          <span
            v-for="genre in game.genres"
            :key="genre.id"
            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary-600/20 text-primary-300 border border-primary-600/30"
          >
            {{ genre.name }}
          </span>
        </div>

        <div
          v-if="platformName"
          class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600/20 border border-primary-600/30 rounded-lg"
        >
          <PlatformIcon
            :icon="platformIcon || 'generic'"
            size="lg"
            class="text-primary-400"
          />
          <span class="text-primary-300 font-semibold text-lg">{{ platformName }}</span>
        </div>
      </div>
    </div>
  </div>
</template>
