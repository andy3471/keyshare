<script setup lang="ts">
import { ref, watch, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { PlatformData } from '@/Types/generated';
import games from '@/routes/games';

interface Props {
  platforms: PlatformData[];
  selectedPlatforms?: string[];
}

const props = withDefaults(defineProps<Props>(), {
  selectedPlatforms: () => [],
});

const showPlatformDropdown = ref(false);
const selectedPlatforms = ref<string[]>([...props.selectedPlatforms]);

const togglePlatformDropdown = () => {
  showPlatformDropdown.value = !showPlatformDropdown.value;
};

const togglePlatform = (platformId: string) => {
  const index = selectedPlatforms.value.indexOf(platformId);
  if (index > -1) {
    selectedPlatforms.value.splice(index, 1);
  } else {
    selectedPlatforms.value.push(platformId);
  }
  applyFilters();
};

const removePlatform = (platformId: string) => {
  const index = selectedPlatforms.value.indexOf(platformId);
  if (index > -1) {
    selectedPlatforms.value.splice(index, 1);
    applyFilters();
  }
};

const clearFilters = () => {
  selectedPlatforms.value = [];
  applyFilters();
};

const getPlatformName = (platformId: string): string => {
  const platform = props.platforms.find(p => p.id === platformId);
  return platform?.name ?? platformId;
};

const applyFilters = () => {
  const query: Record<string, string[]> = {};

  if (selectedPlatforms.value.length > 0) {
    query.platforms = selectedPlatforms.value;
  }

  router.get(games.index.url({ query }), {}, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  });
};

// Close dropdown when clicking outside
const handleClickOutside = (event: MouseEvent) => {
  const target = event.target as HTMLElement;
  if (!target.closest('.relative')) {
    showPlatformDropdown.value = false;
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});

// Watch for URL changes to sync selected platforms
watch(() => props.selectedPlatforms, (newValue) => {
  selectedPlatforms.value = [...newValue];
}, { immediate: true });
</script>

<template>
  <div class="bg-dark-800 rounded-lg border border-dark-700 p-4 mb-6">
    <div class="flex flex-wrap items-center gap-4">
      <div class="flex-1 min-w-[200px]">
        <label class="block text-sm font-medium text-gray-300 mb-2">Platforms</label>
        <div
          class="relative"
          data-platform-dropdown
        >
          <button
            class="w-full bg-dark-700 border border-dark-600 rounded-lg px-4 py-2 text-left text-sm text-gray-300 hover:border-accent-500 transition-colors flex items-center justify-between"
            @click.stop="togglePlatformDropdown"
          >
            <span
              v-if="selectedPlatforms.length === 0"
              class="text-gray-500"
            >All Platforms</span>
            <span
              v-else
              class="text-white"
            >{{ selectedPlatforms.length }} selected</span>
            <svg
              class="h-5 w-5 transition-transform duration-200"
              :class="{ 'rotate-180': showPlatformDropdown }"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
          </button>
          <div
            v-if="showPlatformDropdown"
            class="absolute z-50 mt-2 w-full bg-dark-800 border border-dark-700 rounded-lg shadow-xl max-h-64 overflow-y-auto"
          >
            <div class="p-2">
              <label
                v-for="platform in platforms"
                :key="platform.id"
                class="flex items-center px-3 py-2 rounded hover:bg-dark-700 cursor-pointer"
              >
                <input
                  type="checkbox"
                  :value="platform.id"
                  :checked="selectedPlatforms.includes(platform.id)"
                  class="w-4 h-4 text-accent-600 bg-dark-700 border-dark-600 rounded focus:ring-accent-500 focus:ring-2"
                  @change="togglePlatform(platform.id)"
                >
                <span class="ml-3 text-sm text-gray-300">{{ platform.name }}</span>
              </label>
            </div>
          </div>
        </div>
      </div>

      <div
        v-if="selectedPlatforms.length > 0"
        class="flex items-center gap-2"
      >
        <button
          class="px-4 py-2 text-sm text-gray-400 hover:text-white transition-colors"
          @click="clearFilters"
        >
          Clear filters
        </button>
      </div>
    </div>

    <!-- Selected platform chips -->
    <div
      v-if="selectedPlatforms.length > 0"
      class="mt-3 flex flex-wrap gap-2"
    >
      <span
        v-for="platformId in selectedPlatforms"
        :key="platformId"
        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-accent-600/20 text-accent-400 border border-accent-600/30"
      >
        {{ getPlatformName(platformId) }}
        <button
          class="ml-2 hover:text-white transition-colors"
          @click="removePlatform(platformId)"
        >
          <svg
            class="w-3 h-3"
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
      </span>
    </div>
  </div>
</template>
