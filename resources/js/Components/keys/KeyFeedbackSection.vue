<script setup lang="ts">
import type { KeyFeedback } from '@/Types/generated';
import { HandThumbUpIcon, HandThumbDownIcon } from '@heroicons/vue/24/outline';

interface Props {
  feedback: KeyFeedback | null;
  canFeedback: boolean;
}

defineProps<Props>();

const emit = defineEmits<{
  submit: [value: KeyFeedback];
}>();
</script>

<template>
  <div
    v-if="canFeedback"
    class="pt-4 border-t border-dark-700"
  >
    <p class="text-sm text-gray-400 mb-3 text-center">
      Did this key work?
    </p>

    <div
      v-if="feedback === null"
      class="flex items-center justify-center gap-4"
    >
      <button
        type="button"
        class="group relative flex items-center gap-2 px-5 py-2.5 bg-success/10 border border-success/30 rounded-lg text-success hover:bg-success/20 hover:border-success/50 transition-all duration-200"
        @click="emit('submit', 'worked')"
      >
        <HandThumbUpIcon class="w-5 h-5" />
        <span class="font-medium text-sm">It worked</span>
        <span class="absolute -top-10 left-1/2 -translate-x-1/2 px-3 py-1.5 bg-dark-700 text-gray-200 text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none shadow-lg border border-dark-600">
          The key redeemed successfully
        </span>
      </button>
      <button
        type="button"
        class="group relative flex items-center gap-2 px-5 py-2.5 bg-danger/10 border border-danger/30 rounded-lg text-danger hover:bg-danger/20 hover:border-danger/50 transition-all duration-200"
        @click="emit('submit', 'did_not_work')"
      >
        <HandThumbDownIcon class="w-5 h-5" />
        <span class="font-medium text-sm">It didn't work</span>
        <span class="absolute -top-10 left-1/2 -translate-x-1/2 px-3 py-1.5 bg-dark-700 text-gray-200 text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none shadow-lg border border-dark-600">
          The key was invalid or already used
        </span>
      </button>
    </div>

    <div
      v-else
      class="flex items-center justify-center gap-2"
    >
      <div
        v-if="feedback === 'worked'"
        class="flex items-center gap-2 px-4 py-2 bg-success/10 border border-success/30 rounded-lg text-success"
      >
        <HandThumbUpIcon class="w-5 h-5" />
        <span class="text-sm font-medium">You marked this key as working</span>
      </div>
      <div
        v-else
        class="flex items-center gap-2 px-4 py-2 bg-danger/10 border border-danger/30 rounded-lg text-danger"
      >
        <HandThumbDownIcon class="w-5 h-5" />
        <span class="text-sm font-medium">You reported this key as not working</span>
      </div>
    </div>
  </div>
</template>
