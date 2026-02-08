<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import GameHeader from '@/Components/games/GameHeader.vue';
import ScreenshotGallery from '@/Components/games/ScreenshotGallery.vue';
import GameList from '@/Components/games/GameList.vue';
import KeyCard from '@/Components/keys/KeyCard.vue';
import GameImagePlaceholder from '@/Components/shared/GameImagePlaceholder.vue';
import EmptyState from '@/Components/shared/EmptyState.vue';
import { GameData, KeyData } from '@/Types/generated';
import type { AuthUser, Paginated } from '@/types/global';
import gamesRoute from '@/routes/games';
import keysRoute from '@/routes/keys';
import { PlusIcon, KeyIcon } from '@heroicons/vue/24/outline';

interface Props {
  game: GameData;
  keys: KeyData[];
  childGames?: Paginated<GameData>;
  parentGame?: GameData;
}

defineProps<Props>();

const page = usePage();
const auth = (page.props.auth as AuthUser | undefined) ?? { user: null };
</script>

<template>
  <AppLayout :title="game.name">
    <Head :title="game.name" />
    <div class="max-w-7xl mx-auto px-4 py-6">
      <div
        v-if="parentGame"
        class="mb-6"
      >
        <div class="bg-dark-800 rounded-lg border border-dark-700 p-4 flex items-center gap-4">
          <span class="text-sm text-gray-400">DLC for:</span>
          <Link
            :href="gamesRoute.show.url(parentGame.id)"
            class="flex items-center gap-3 hover:opacity-80 transition-opacity"
          >
            <img
              v-if="parentGame.image"
              :src="parentGame.image"
              :alt="parentGame.name"
              class="w-12 h-16 rounded object-cover border border-dark-700"
            >
            <div
              v-else
              class="w-12 h-16"
            >
              <GameImagePlaceholder size="sm" />
            </div>
            <span class="text-white font-medium">{{ parentGame.name }}</span>
          </Link>
        </div>
      </div>

      <GameHeader :game="game" />

      <div class="flex items-center justify-between mb-4 mt-8">
        <h2 class="text-2xl font-bold text-white">
          Available Keys
        </h2>
        <Link
          v-if="auth.user"
          :href="keysRoute.create.url({ query: { game_id: game.id } })"
          class="inline-flex items-center gap-2 bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5 active:translate-y-0"
        >
          <PlusIcon class="w-4 h-4" />
          Add a Key
        </Link>
      </div>

      <EmptyState
        v-if="keys.length === 0"
        title="No keys available"
        message="Be the first to share a key for this game!"
      >
        <template #icon>
          <KeyIcon class="w-16 h-16 text-gray-600" />
        </template>
      </EmptyState>

      <div
        v-else
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
      >
        <KeyCard
          v-for="keyItem in keys"
          :key="keyItem.id"
          :key-data="keyItem"
        />
      </div>

      <div
        v-if="childGames && childGames.data && childGames.data.length > 0"
        class="mt-8"
      >
        <h2 class="text-2xl font-bold text-white mb-4">
          DLC / Expansions
        </h2>
        <GameList
          :games="childGames"
          scroll-prop="childGames"
        />
      </div>

      <ScreenshotGallery
        v-if="game.screenshots && game.screenshots.length > 0"
        :screenshots="game.screenshots"
      />
    </div>
  </AppLayout>
</template>
