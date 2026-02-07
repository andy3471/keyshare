<template>
  <AppLayout :title="game.name">
    <Head :title="game.name" />
    <div class="max-w-7xl mx-auto px-4 py-6">
      <!-- Parent Game Info (if this is a DLC) -->
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
              class="w-12 h-16 rounded flex items-center justify-center bg-gradient-to-br from-dark-800 via-dark-700 to-dark-800 border border-dark-700"
            >
              <svg
                class="w-6 h-6 text-accent-500/50"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  d="M14.752 11.168l-3.197-2.132A1 1 0 0011 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </div>
            <span class="text-white font-medium">{{ parentGame.name }}</span>
          </Link>
        </div>
      </div>

      <!-- Game Header: Image and Description Side by Side -->
      <div class="flex flex-col lg:flex-row gap-6 mb-8">
        <!-- Game Image - Compact game cover size -->
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
              class="w-full rounded-lg aspect-[2/3] flex items-center justify-center bg-gradient-to-br from-dark-800 via-dark-700 to-dark-800 border-2 border-accent-600/30 game-image-placeholder"
            >
              <svg
                class="w-16 h-16 text-accent-500/50"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  d="M14.752 11.168l-3.197-2.132A1 1 0 0011 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </div>
          </div>
        </div>

        <!-- Game Info Card - Takes remaining space -->
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
            v-if="igdb && igdb.aggregated_rating"
            class="mb-4 text-gray-300"
          >
            <div class="flex items-center space-x-2">
              <svg
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
              </svg>
              <span class="font-semibold">{{ igdb.aggregated_rating }}</span>
              <span class="text-gray-500">({{ igdb.aggregated_rating_count }} reviews)</span>
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

      <h2 class="text-2xl font-bold text-white mb-4 mt-8">
        Available Keys
      </h2>

      <div
        v-if="keys.length === 0"
        class="bg-dark-800 rounded-lg border border-dark-700 p-12 text-center"
      >
        <div class="inline-flex flex-col items-center space-y-4">
          <svg
            class="w-16 h-16 text-gray-600"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="1.5"
              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"
            />
          </svg>
          <div>
            <p class="text-xl font-medium text-gray-300">
              No keys available
            </p>
            <p class="text-sm text-gray-500 mt-1">
              Be the first to share a key for this game!
            </p>
          </div>
        </div>
      </div>
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
        <TitleHeader title="DLC / Expansions" />
        <GameList
          :games="childGames"
          scroll-prop="childGames"
        />
      </div>

      <div
        v-if="game.screenshots && game.screenshots.length > 0"
        class="mt-8"
      >
        <h2 class="text-2xl font-bold text-white mb-4">
          Screenshots
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <img
            v-for="(screenshot, index) in game.screenshots"
            :key="screenshot.id"
            :src="`https://images.igdb.com/igdb/image/upload/t_screenshot_big/${screenshot.image_id}.jpg`"
            alt="Game Screenshot"
            class="rounded-lg border border-dark-700 w-full h-auto cursor-pointer hover:border-accent-500 transition-colors"
            @click="openImageModal(index)"
          >
        </div>
      </div>

      <!-- Image Modal -->
      <div
        v-if="selectedImageIndex !== null && game.screenshots && game.screenshots.length > 0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm"
        @click="closeImageModal"
      >
        <div
          class="relative max-w-7xl max-h-[90vh] mx-4 flex items-center"
          @click.stop
        >
          <!-- Close Button -->
          <button
            class="absolute -top-12 right-0 text-white hover:text-accent-400 transition-colors z-10"
            @click="closeImageModal"
          >
            <svg
              class="w-8 h-8"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>

          <!-- Previous Button -->
          <button
            v-if="game.screenshots.length > 1"
            class="absolute left-4 text-white hover:text-accent-400 transition-colors p-3 rounded-lg hover:bg-white/10 bg-black/50 backdrop-blur-sm"
            :disabled="selectedImageIndex === 0"
            :class="{ 'opacity-50 cursor-not-allowed': selectedImageIndex === 0 }"
            @click.stop="previousImage"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 19l-7-7 7-7"
              />
            </svg>
          </button>

          <!-- Image -->
          <img
            :src="`https://images.igdb.com/igdb/image/upload/t_screenshot_big/${game.screenshots[selectedImageIndex].image_id}.jpg`"
            alt="Game Screenshot"
            class="max-w-full max-h-[90vh] rounded-lg shadow-2xl"
          >

          <!-- Next Button -->
          <button
            v-if="game.screenshots.length > 1"
            class="absolute right-4 text-white hover:text-accent-400 transition-colors p-3 rounded-lg hover:bg-white/10 bg-black/50 backdrop-blur-sm"
            :disabled="selectedImageIndex === game.screenshots.length - 1"
            :class="{ 'opacity-50 cursor-not-allowed': selectedImageIndex === game.screenshots.length - 1 }"
            @click.stop="nextImage"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5l7 7-7 7"
              />
            </svg>
          </button>

          <!-- Image Counter -->
          <div
            v-if="game.screenshots.length > 1"
            class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/70 backdrop-blur-sm text-white px-4 py-2 rounded-lg text-sm font-medium"
          >
            {{ selectedImageIndex + 1 }} / {{ game.screenshots.length }}
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleHeader from '@/Components/TitleHeader.vue';
import GameList from '@/Components/GameList.vue';
import KeyCard from '@/Components/KeyCard.vue';
import { GameShowData } from '@/Types/generated';
import gamesRoute from '@/routes/games';

interface Props {
  game: GameShowData['game'];
  keys: GameShowData['keys'];
  childGames?: {
    data: { id: number; igdb_id: number; name: string; image?: string; url: string; hasKey: boolean; keyCount: number }[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
  igdb?: {
    aggregated_rating?: number;
    aggregated_rating_count?: number;
  };
  parentGame?: {
    id: string;
    name: string;
    image?: string;
  };
}

const props = defineProps<Props>();

const selectedImageIndex = ref<number | null>(null);

const openImageModal = (index: number) => {
  selectedImageIndex.value = index;
  document.body.style.overflow = 'hidden';
};

const closeImageModal = () => {
  selectedImageIndex.value = null;
  document.body.style.overflow = '';
};

const nextImage = () => {
  if (selectedImageIndex.value !== null && props.game.screenshots && selectedImageIndex.value < props.game.screenshots.length - 1) {
    selectedImageIndex.value = selectedImageIndex.value + 1;
  }
};

const previousImage = () => {
  if (selectedImageIndex.value !== null && selectedImageIndex.value > 0) {
    selectedImageIndex.value--;
  }
};

const handleKeyDown = (event: KeyboardEvent) => {
  if (selectedImageIndex.value === null) return;

  if (event.key === 'Escape') {
    closeImageModal();
  } else if (event.key === 'ArrowLeft') {
    previousImage();
  } else if (event.key === 'ArrowRight') {
    nextImage();
  }
};

onMounted(() => {
  window.addEventListener('keydown', handleKeyDown);
});

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeyDown);
});
</script>

<style scoped>
</style>
