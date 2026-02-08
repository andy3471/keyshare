<script setup lang="ts">
import { ref, computed } from 'vue';
import ImageGalleryModal from '@/Components/shared/ImageGalleryModal.vue';
import { ScreenshotData } from '@/Types/generated';

interface Props {
  screenshots: ScreenshotData[];
}

const props = defineProps<Props>();

const selectedIndex = ref(0);
const modalOpen = ref(false);

const imageUrls = computed(() =>
  props.screenshots.map(s => `https://images.igdb.com/igdb/image/upload/t_screenshot_big/${s.image_id}.jpg`),
);

const openModal = (index: number) => {
  selectedIndex.value = index;
  modalOpen.value = true;
};
</script>

<template>
  <div class="mt-8">
    <h2 class="text-2xl font-bold text-white mb-4">
      Screenshots
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <img
        v-for="(screenshot, index) in screenshots"
        :key="screenshot.id"
        :src="imageUrls[index]"
        alt="Game Screenshot"
        class="rounded-lg border border-dark-700 w-full h-auto cursor-pointer hover:border-accent-500 transition-colors"
        @click="openModal(index)"
      >
    </div>

    <ImageGalleryModal
      :open="modalOpen"
      :images="imageUrls"
      :selected-index="selectedIndex"
      @close="modalOpen = false"
      @update:selected-index="selectedIndex = $event"
    />
  </div>
</template>
