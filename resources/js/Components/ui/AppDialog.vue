<script setup lang="ts">
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionRoot,
  TransitionChild,
} from '@headlessui/vue';

interface Props {
  open: boolean;
  title?: string;
  maxWidth?: 'sm' | 'md' | 'lg' | 'xl';
}

withDefaults(defineProps<Props>(), {
  title: '',
  maxWidth: 'md',
});

const emit = defineEmits<{
  close: [];
}>();

const maxWidthClasses: Record<string, string> = {
  sm: 'max-w-sm',
  md: 'max-w-md',
  lg: 'max-w-lg',
  xl: 'max-w-xl',
};
</script>

<template>
  <TransitionRoot
    :show="open"
    as="template"
  >
    <Dialog
      class="relative z-50"
      @close="emit('close')"
    >
      <TransitionChild
        as="template"
        enter="transition duration-200 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="transition duration-150 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" />
      </TransitionChild>

      <div class="fixed inset-0 flex items-center justify-center p-4">
        <TransitionChild
          as="template"
          enter="transition duration-200 ease-out"
          enter-from="opacity-0 scale-95 translate-y-2"
          enter-to="opacity-100 scale-100 translate-y-0"
          leave="transition duration-150 ease-in"
          leave-from="opacity-100 scale-100 translate-y-0"
          leave-to="opacity-0 scale-95 translate-y-2"
        >
          <DialogPanel
            class="relative bg-dark-800 rounded-xl shadow-2xl shadow-dark-950/50 border border-dark-700 w-full p-6"
            :class="maxWidthClasses[maxWidth]"
          >
            <DialogTitle
              v-if="title"
              class="text-lg font-semibold text-white"
            >
              {{ title }}
            </DialogTitle>
            <slot />
          </DialogPanel>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
