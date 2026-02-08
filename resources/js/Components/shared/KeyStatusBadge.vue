<script setup lang="ts">
import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/24/outline';

interface Props {
  canClaim: boolean;
}

defineProps<Props>();
</script>

<template>
  <div
    class="flex items-center gap-1 text-xs font-medium"
    :class="canClaim ? 'text-success' : 'text-gray-500'"
  >
    <CheckCircleIcon
      v-if="canClaim"
      class="w-4 h-4"
    />
    <XCircleIcon
      v-else
      class="w-4 h-4"
    />
    <span>{{ canClaim ? 'Available' : 'Claimed' }}</span>
  </div>
</template>
