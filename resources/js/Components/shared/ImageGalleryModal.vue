<script setup lang="ts">
import { onMounted, onUnmounted } from 'vue';
import AppDialog from '@/Components/ui/AppDialog.vue';
import { ChevronLeftIcon, ChevronRightIcon, XMarkIcon } from '@heroicons/vue/24/outline';

interface Props {
  open: boolean;
  images: string[];
  selectedIndex: number;
}

const props = defineProps<Props>();

const emit = defineEmits<{
  close: [];
  'update:selectedIndex': [index: number];
}>();

const next = () => {
  if (props.selectedIndex < props.images.length - 1) {
    emit('update:selectedIndex', props.selectedIndex + 1);
  }
};

const previous = () => {
  if (props.selectedIndex > 0) {
    emit('update:selectedIndex', props.selectedIndex - 1);
  }
};

const handleKeyDown = (event: KeyboardEvent) => {
  if (!props.open) return;
  if (event.key === 'ArrowLeft') previous();
  if (event.key === 'ArrowRight') next();
};

onMounted(() => { window.addEventListener('keydown', handleKeyDown); });
onUnmounted(() => { window.removeEventListener('keydown', handleKeyDown); });
</script>

<template>
  <AppDialog
    :open="open"
    max-width="xl"
    bare
    @close="emit('close')"
  >
    <div class="relative flex items-center justify-center">
      <button
        class="absolute -top-2 -right-2 text-white hover:text-accent-400 transition-colors z-10 bg-dark-800/80 backdrop-blur-sm rounded-full p-1.5"
        @click="emit('close')"
      >
        <XMarkIcon class="w-6 h-6" />
      </button>

      <button
        v-if="images.length > 1"
        class="absolute left-4 text-white hover:text-accent-400 transition-colors p-3 rounded-lg hover:bg-white/10 bg-black/50 backdrop-blur-sm disabled:opacity-50 disabled:cursor-not-allowed"
        :disabled="selectedIndex === 0"
        @click="previous"
      >
        <ChevronLeftIcon class="w-6 h-6" />
      </button>

      <img
        :src="images[selectedIndex]"
        alt="Gallery image"
        class="max-w-full max-h-[70vh] rounded-lg shadow-2xl"
      >

      <button
        v-if="images.length > 1"
        class="absolute right-4 text-white hover:text-accent-400 transition-colors p-3 rounded-lg hover:bg-white/10 bg-black/50 backdrop-blur-sm disabled:opacity-50 disabled:cursor-not-allowed"
        :disabled="selectedIndex === images.length - 1"
        @click="next"
      >
        <ChevronRightIcon class="w-6 h-6" />
      </button>

      <div
        v-if="images.length > 1"
        class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/70 backdrop-blur-sm text-white px-4 py-2 rounded-lg text-sm font-medium"
      >
        {{ selectedIndex + 1 }} / {{ images.length }}
      </div>
    </div>
  </AppDialog>
</template>
