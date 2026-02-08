<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import KeyAvailabilityBadge from '@/Components/shared/KeyAvailabilityBadge.vue';
import gamesRoute from '@/routes/games';
import { GameData } from '@/Types/generated';
import { TicketIcon } from '@heroicons/vue/24/outline';

interface Props {
  game: GameData;
}

defineProps<Props>();
</script>

<template>
  <div
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
        <TicketIcon class="w-10 h-10 text-dark-500" />
      </div>
      <div class="game-overlay">
        {{ game.name }}
      </div>
    </Link>
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
