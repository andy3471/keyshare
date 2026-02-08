<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import GameImagePlaceholder from '@/Components/shared/GameImagePlaceholder.vue';
import games from '@/routes/games';
import { GameData } from '@/Types/generated';
import { CheckCircleIcon } from '@heroicons/vue/24/outline';

interface Props {
  game: GameData;
  platformName?: string;
}

defineProps<Props>();
</script>

<template>
  <div class="bg-dark-800 rounded-lg border border-dark-700 p-6">
    <div class="flex flex-col lg:flex-row gap-6">
      <div class="flex-shrink-0">
        <Link
          :href="games.show.url(game.id)"
          class="block"
        >
          <div class="w-[180px]">
            <img
              v-if="game.image"
              :src="game.image"
              :alt="game.name"
              class="w-full rounded-lg border border-dark-700 object-cover aspect-[2/3] hover:border-accent-500 transition-colors"
            >
            <div
              v-else
              class="w-full aspect-[2/3]"
            >
              <GameImagePlaceholder size="lg" />
            </div>
          </div>
        </Link>
      </div>

      <div class="flex-1">
        <Link
          :href="games.show.url(game.id)"
          class="block mb-4"
        >
          <h1 class="text-3xl font-bold text-white hover:text-accent-400 transition-colors mb-2">
            {{ game.name }}
          </h1>
        </Link>

        <p
          v-if="game.description"
          class="text-gray-300 text-sm leading-relaxed line-clamp-4 mb-4"
        >
          {{ game.description }}
        </p>

        <div
          v-if="platformName"
          class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600/20 border border-primary-600/30 rounded-lg"
        >
          <CheckCircleIcon class="w-5 h-5 text-primary-400" />
          <span class="text-primary-300 font-semibold text-lg">{{ platformName }}</span>
        </div>
      </div>
    </div>
  </div>
</template>
