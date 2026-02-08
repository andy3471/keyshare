<script setup lang="ts">
import { ref } from 'vue';
import { PhotoIcon } from '@heroicons/vue/24/outline';

interface Props {
  currentImage?: string | null;
  initials?: string;
  shape?: 'round' | 'square';
  error?: string;
  label?: string;
}

const props = withDefaults(defineProps<Props>(), {
  currentImage: null,
  initials: '?',
  shape: 'square',
  error: '',
  label: 'Upload Image',
});

const emit = defineEmits<{
  'update:file': [file: File];
}>();

const preview = ref<string | null>(null);

const displayImage = () => preview.value ?? props.currentImage;

const handleChange = (event: Event) => {
  const file = (event.target as HTMLInputElement).files?.[0];
  if (file) {
    preview.value = URL.createObjectURL(file);
    emit('update:file', file);
  }
};

const shapeClasses = () => props.shape === 'round' ? 'rounded-full' : 'rounded-xl';
</script>

<template>
  <div>
    <label
      v-if="label"
      class="block text-sm font-medium text-gray-300 mb-3"
    >
      {{ label }}
      <slot name="label-suffix" />
    </label>
    <div class="flex items-center gap-4">
      <div class="relative">
        <div
          v-if="displayImage()"
          class="w-20 h-20 overflow-hidden border-2 border-dark-600"
          :class="shapeClasses()"
        >
          <img
            :src="displayImage()!"
            alt="Avatar"
            class="w-full h-full object-cover"
          >
        </div>
        <div
          v-else
          class="w-20 h-20 bg-accent-600/20 border-2 border-dark-600 flex items-center justify-center"
          :class="shapeClasses()"
        >
          <span class="text-accent-400 font-bold text-2xl">{{ initials }}</span>
        </div>
      </div>
      <div>
        <label
          for="avatar-upload"
          class="inline-flex items-center px-4 py-2 bg-dark-700 hover:bg-dark-600 text-gray-300 text-sm font-medium rounded-lg transition-colors cursor-pointer"
        >
          <PhotoIcon class="w-4 h-4 mr-2" />
          {{ currentImage ? 'Change Image' : 'Upload Image' }}
          <input
            id="avatar-upload"
            type="file"
            accept="image/*"
            class="hidden"
            @change="handleChange"
          >
        </label>
        <p class="text-xs text-gray-500 mt-1">
          JPG, PNG or GIF. Max 2MB.
        </p>
      </div>
    </div>
    <p
      v-if="error"
      class="mt-1 text-sm text-danger-400"
    >
      {{ error }}
    </p>
  </div>
</template>
