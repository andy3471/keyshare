<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue';
import { PlatformData } from '@/Types/generated';
import games from '@/routes/games';
import { ChevronDownIcon, XMarkIcon } from '@heroicons/vue/20/solid';

interface Props {
  platforms: PlatformData[];
  selectedPlatforms?: string[];
}

const props = withDefaults(defineProps<Props>(), {
  selectedPlatforms: () => [],
});

const selected = ref<string[]>([...props.selectedPlatforms]);

const togglePlatform = (platformId: string) => {
  const index = selected.value.indexOf(platformId);
  if (index > -1) {
    selected.value.splice(index, 1);
  } else {
    selected.value.push(platformId);
  }
  applyFilters();
};

const removePlatform = (platformId: string) => {
  const index = selected.value.indexOf(platformId);
  if (index > -1) {
    selected.value.splice(index, 1);
    applyFilters();
  }
};

const clearFilters = () => {
  selected.value = [];
  applyFilters();
};

const getPlatformName = (platformId: string): string => {
  return props.platforms.find(p => p.id === platformId)?.name ?? platformId;
};

const applyFilters = () => {
  const query: Record<string, string[]> = {};
  if (selected.value.length > 0) {
    query.platforms = selected.value;
  }
  router.get(games.index.url({ query }), {}, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  });
};

watch(() => props.selectedPlatforms, (newValue) => {
  selected.value = [...newValue];
}, { immediate: true });
</script>

<template>
  <div class="bg-dark-800 rounded-lg border border-dark-700 p-4 mb-6">
    <div class="flex flex-wrap items-center gap-4">
      <div class="flex-1 min-w-[200px]">
        <label class="block text-sm font-medium text-gray-300 mb-2">Platforms</label>
        <Popover class="relative">
          <PopoverButton class="w-full bg-dark-700 border border-dark-600 rounded-lg px-4 py-2 text-left text-sm text-gray-300 hover:border-accent-500 transition-colors flex items-center justify-between">
            <span
              v-if="selected.length === 0"
              class="text-gray-500"
            >All Platforms</span>
            <span
              v-else
              class="text-white"
            >{{ selected.length }} selected</span>
            <ChevronDownIcon class="h-5 w-5 transition-transform duration-200" />
          </PopoverButton>

          <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
          >
            <PopoverPanel class="absolute z-50 mt-2 w-full bg-dark-800 border border-dark-700 rounded-lg shadow-xl max-h-64 overflow-y-auto">
              <div class="p-2">
                <label
                  v-for="platform in platforms"
                  :key="platform.id"
                  class="flex items-center px-3 py-2 rounded hover:bg-dark-700 cursor-pointer"
                >
                  <input
                    type="checkbox"
                    :value="platform.id"
                    :checked="selected.includes(platform.id)"
                    class="w-4 h-4 text-accent-600 bg-dark-700 border-dark-600 rounded focus:ring-accent-500 focus:ring-2"
                    @change="togglePlatform(platform.id)"
                  >
                  <span class="ml-3 text-sm text-gray-300">{{ platform.name }}</span>
                </label>
              </div>
            </PopoverPanel>
          </transition>
        </Popover>
      </div>

      <div
        v-if="selected.length > 0"
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

    <div
      v-if="selected.length > 0"
      class="mt-3 flex flex-wrap gap-2"
    >
      <span
        v-for="platformId in selected"
        :key="platformId"
        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-accent-600/20 text-accent-400 border border-accent-600/30"
      >
        {{ getPlatformName(platformId) }}
        <button
          class="ml-2 hover:text-white transition-colors"
          @click="removePlatform(platformId)"
        >
          <XMarkIcon class="w-3 h-3" />
        </button>
      </span>
    </div>
  </div>
</template>
