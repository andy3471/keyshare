<script setup lang="ts">
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import type { FlashProps } from '@/types/global';
import { CheckCircleIcon, XCircleIcon, XMarkIcon } from '@heroicons/vue/24/outline';

const page = usePage();
const flash = ref<FlashProps>({});
const visible = ref(false);

watch(() => page.props.flash as FlashProps | undefined, (newFlash) => {
  flash.value = newFlash ?? {};
  visible.value = (flash.value.message != null && flash.value.message !== '') || (flash.value.error != null && flash.value.error !== '');

  if (visible.value) {
    setTimeout(() => {
      visible.value = false;
    }, 5000);
  }
}, { immediate: true });

const dismiss = () => {
  visible.value = false;
};
</script>

<template>
  <transition
    enter-active-class="transition ease-out duration-300"
    enter-from-class="opacity-0 translate-y-2"
    enter-to-class="opacity-100 translate-y-0"
    leave-active-class="transition ease-in duration-200"
    leave-from-class="opacity-100 translate-y-0"
    leave-to-class="opacity-0 translate-y-2"
  >
    <div
      v-if="visible && (flash.message || flash.error)"
      class="fixed bottom-6 right-6 z-50 max-w-sm"
    >
      <div
        v-if="flash.message"
        class="bg-dark-800 border border-success/30 rounded-lg shadow-xl p-4 flex items-start gap-3"
      >
        <CheckCircleIcon class="w-5 h-5 text-success flex-shrink-0 mt-0.5" />
        <p class="text-gray-200 text-sm flex-1">
          {{ flash.message }}
        </p>
        <button
          class="text-gray-500 hover:text-white transition-colors"
          @click="dismiss"
        >
          <XMarkIcon class="w-4 h-4" />
        </button>
      </div>

      <div
        v-if="flash.error"
        class="bg-dark-800 border border-danger/30 rounded-lg shadow-xl p-4 flex items-start gap-3"
      >
        <XCircleIcon class="w-5 h-5 text-danger flex-shrink-0 mt-0.5" />
        <p class="text-gray-200 text-sm flex-1">
          {{ flash.error }}
        </p>
        <button
          class="text-gray-500 hover:text-white transition-colors"
          @click="dismiss"
        >
          <XMarkIcon class="w-4 h-4" />
        </button>
      </div>
    </div>
  </transition>
</template>
