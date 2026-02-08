<script setup lang="ts">
import { watch } from 'vue';

interface Props {
  open: boolean;
  title?: string;
  message?: string;
  confirmLabel?: string;
  cancelLabel?: string;
  variant?: 'danger' | 'warning' | 'default';
}

const props = withDefaults(defineProps<Props>(), {
  title: 'Are you sure?',
  message: '',
  confirmLabel: 'Confirm',
  cancelLabel: 'Cancel',
  variant: 'default',
});

const emit = defineEmits<{
  confirm: [];
  cancel: [];
}>();

watch(() => props.open, (isOpen) => {
  if (isOpen) {
    document.body.style.overflow = 'hidden';
  } else {
    document.body.style.overflow = '';
  }
});

const handleBackdropClick = (event: MouseEvent) => {
  if (event.target === event.currentTarget) {
    emit('cancel');
  }
};

const handleKeydown = (event: KeyboardEvent) => {
  if (event.key === 'Escape') {
    emit('cancel');
  }
};

const variantClasses = {
  danger: 'bg-danger-600 hover:bg-danger-700 shadow-danger-600/20',
  warning: 'bg-warning hover:bg-yellow-600 shadow-warning/20',
  default: 'bg-accent-600 hover:bg-accent-700 shadow-accent-600/20',
};

const variantIconClasses = {
  danger: 'text-danger-400 bg-danger-600/20',
  warning: 'text-warning bg-warning/20',
  default: 'text-accent-400 bg-accent-600/20',
};
</script>

<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="open"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @click="handleBackdropClick"
        @keydown="handleKeydown"
      >
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" />

        <!-- Modal -->
        <Transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0 scale-95 translate-y-2"
          enter-to-class="opacity-100 scale-100 translate-y-0"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="opacity-100 scale-100 translate-y-0"
          leave-to-class="opacity-0 scale-95 translate-y-2"
        >
          <div
            v-if="open"
            class="relative bg-dark-800 rounded-xl shadow-2xl shadow-dark-950/50 border border-dark-700 w-full max-w-md p-6"
          >
            <div class="flex items-start gap-4">
              <!-- Icon -->
              <div
                class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center"
                :class="variantIconClasses[variant]"
              >
                <!-- Warning/Danger icon -->
                <svg
                  v-if="variant === 'danger' || variant === 'warning'"
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                  />
                </svg>
                <!-- Default icon -->
                <svg
                  v-else
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
              </div>

              <!-- Content -->
              <div class="flex-1 min-w-0">
                <h3 class="text-lg font-semibold text-white">
                  {{ title }}
                </h3>
                <p
                  v-if="message"
                  class="mt-1.5 text-sm text-gray-400"
                >
                  {{ message }}
                </p>
                <slot />
              </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 mt-6">
              <button
                type="button"
                class="px-4 py-2 bg-dark-700 hover:bg-dark-600 text-gray-300 hover:text-white text-sm font-medium rounded-lg transition-colors"
                @click="emit('cancel')"
              >
                {{ cancelLabel }}
              </button>
              <button
                type="button"
                class="px-4 py-2 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-lg"
                :class="variantClasses[variant]"
                @click="emit('confirm')"
              >
                {{ confirmLabel }}
              </button>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>
