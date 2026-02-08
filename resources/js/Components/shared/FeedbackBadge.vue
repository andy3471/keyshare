<script setup lang="ts">
import { HandThumbUpIcon, HandThumbDownIcon, ClockIcon } from '@heroicons/vue/24/outline';
import type { KeyFeedback } from '@/Types/generated';

interface Props {
  feedback: KeyFeedback | null;
  hasClaimer: boolean;
}

defineProps<Props>();
</script>

<template>
  <div
    v-if="feedback === 'worked'"
    class="flex items-center gap-1 text-xs font-medium text-success"
  >
    <HandThumbUpIcon class="w-3.5 h-3.5" />
    <span>Worked</span>
  </div>
  <div
    v-else-if="feedback === 'did_not_work'"
    class="flex items-center gap-1 text-xs font-medium text-danger"
  >
    <HandThumbDownIcon class="w-3.5 h-3.5" />
    <span>Didn't work</span>
  </div>
  <div
    v-else-if="hasClaimer && feedback === null"
    class="flex items-center gap-1 text-xs font-medium text-gray-600"
  >
    <ClockIcon class="w-3.5 h-3.5" />
    <span>Awaiting feedback</span>
  </div>
</template>
