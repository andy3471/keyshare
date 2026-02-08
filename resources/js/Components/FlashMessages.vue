<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import type { FlashProps } from '@/types/global';

const page = usePage();
const flash = computed<FlashProps>(() => (page.props.flash as FlashProps | undefined) ?? {});
const showMessage = ref(true);
const showError = ref(true);

watch(() => flash.value.message, (newVal) => {
  if (newVal) {
    showMessage.value = true;
  }
});

watch(() => flash.value.error, (newVal) => {
  if (newVal) {
    showError.value = true;
  }
});

const dismissMessage = () => {
  showMessage.value = false;
};

const dismissError = () => {
  showError.value = false;
};
</script>

<template>
  <Transition
    enter-active-class="transition ease-out duration-300"
    enter-from-class="opacity-0 translate-y-2"
    enter-to-class="opacity-100 translate-y-0"
    leave-active-class="transition ease-in duration-200"
    leave-from-class="opacity-100 translate-y-0"
    leave-to-class="opacity-0 translate-y-2"
  >
    <div
      v-if="(flash.message && showMessage) || (flash.error && showError)"
      class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 max-w-md w-full mx-4"
    >
      <div
        v-if="flash.message && showMessage"
        class="bg-success text-white px-4 py-3 rounded-lg shadow-xl relative flex items-center justify-between border border-success-dark"
        role="alert"
      >
        <span class="flex-1 pr-4">{{ flash.message }}</span>
        <button
          class="flex-shrink-0 hover:bg-success-dark rounded p-1 transition-colors"
          aria-label="Dismiss"
          @click="dismissMessage"
        >
          <svg
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>
      <div
        v-if="flash.error && showError"
        class="bg-danger text-white px-4 py-3 rounded-lg shadow-xl relative flex items-center justify-between border border-danger-dark"
        role="alert"
      >
        <span class="flex-1 pr-4">{{ flash.error }}</span>
        <button
          class="flex-shrink-0 hover:bg-danger-dark rounded p-1 transition-colors"
          aria-label="Dismiss"
          @click="dismissError"
        >
          <svg
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>
    </div>
  </Transition>
</template>
