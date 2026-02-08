<script setup lang="ts">
import { computed, watch } from 'vue';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import GameBanner from '@/Components/shared/GameBanner.vue';
import ScreenshotGallery from '@/Components/games/ScreenshotGallery.vue';
import GameList from '@/Components/games/GameList.vue';
import KeyCard from '@/Components/keys/KeyCard.vue';
import GameImagePlaceholder from '@/Components/shared/GameImagePlaceholder.vue';
import EmptyState from '@/Components/shared/EmptyState.vue';
import { GameData, GroupData, KeyData } from '@/Types/generated';
import type { AuthUser, Paginated } from '@/types/global';
import gamesRoute from '@/routes/games';
import keysRoute from '@/routes/keys';
import { useCountdown } from '@/Composables/useCountdown';
import { PlusIcon, KeyIcon, ClockIcon } from '@heroicons/vue/24/outline';

interface Props {
  game: GameData;
  keys: KeyData[];
  childGames?: Paginated<GameData>;
  parentGame?: GameData;
}

const props = defineProps<Props>();

const page = usePage();
const auth = (page.props.auth as AuthUser | undefined) ?? { user: null };
const activeGroup = computed(() => page.props.activeGroup as GroupData | null);

const cooldownEndsAt = computed(() => {
  if (!activeGroup.value) return null;

  for (const key of props.keys) {
    if (key.can?.claimDeniedReason === 'cooldown_active' && key.can.cooldownEndsAt) {
      return key.can.cooldownEndsAt;
    }
  }
  return null;
});

const { isExpired: cooldownExpired, formatted: cooldownFormatted } = useCountdown(cooldownEndsAt.value);
watch(cooldownExpired, (expired) => {
  if (expired && cooldownEndsAt.value) {
    router.reload({ only: ['keys'] });
  }
});
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

      <GameBanner
        :game="game"
        show-rating
        show-genres
      />

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

      <div
        v-if="cooldownEndsAt && !cooldownExpired"
        class="bg-primary-600/10 border border-primary-600/30 rounded-lg p-4 mb-4"
      >
        <div class="flex items-center gap-3">
          <ClockIcon class="w-5 h-5 text-primary-400 flex-shrink-0" />
          <p class="text-gray-300 text-sm">
            Claim cooldown active — you can claim another key in <span class="text-white font-semibold tabular-nums">{{ cooldownFormatted }}</span>
          </p>
        </div>
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
