<script setup lang="ts">
import AppDialog from '@/Components/ui/AppDialog.vue';
import { ExclamationTriangleIcon, QuestionMarkCircleIcon } from '@heroicons/vue/24/outline';

interface Props {
  open: boolean;
  title?: string;
  message?: string;
  confirmLabel?: string;
  cancelLabel?: string;
  variant?: 'danger' | 'warning' | 'default';
}

withDefaults(defineProps<Props>(), {
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

const variantClasses: Record<string, string> = {
  danger: 'bg-danger-600 hover:bg-danger-700 shadow-danger-600/20',
  warning: 'bg-warning hover:bg-yellow-600 shadow-warning/20',
  default: 'bg-accent-600 hover:bg-accent-700 shadow-accent-600/20',
};

const variantIconClasses: Record<string, string> = {
  danger: 'text-danger-400 bg-danger-600/20',
  warning: 'text-warning bg-warning/20',
  default: 'text-accent-400 bg-accent-600/20',
};
</script>

<template>
  <AppDialog
    :open="open"
    @close="emit('cancel')"
  >
    <div class="flex items-start gap-4">
      <div
        class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center"
        :class="variantIconClasses[variant]"
      >
        <ExclamationTriangleIcon
          v-if="variant === 'danger' || variant === 'warning'"
          class="w-5 h-5"
        />
        <QuestionMarkCircleIcon
          v-else
          class="w-5 h-5"
        />
      </div>

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
  </AppDialog>
</template>
