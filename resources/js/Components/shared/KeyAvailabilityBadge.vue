<script setup lang="ts">
import { KeyIcon, LockClosedIcon } from '@heroicons/vue/24/outline';

interface Props {
  keyCount: number;
}

defineProps<Props>();
</script>

<template>
  <div
    v-if="keyCount > 0"
    class="absolute top-2 right-2 z-10 bg-green-500/95 backdrop-blur-sm rounded-full p-2 shadow-lg shadow-green-500/50"
    :title="`${keyCount} ${keyCount === 1 ? 'key' : 'keys'} available`"
  >
    <KeyIcon class="w-5 h-5 text-white" />
    <span class="absolute -top-1 -right-1 bg-white text-green-600 text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
      {{ keyCount }}
    </span>
  </div>
  <div
    v-else
    class="absolute top-2 right-2 z-10 bg-gray-600/80 backdrop-blur-sm rounded-full p-2"
    title="No keys available"
  >
    <LockClosedIcon class="w-5 h-5 text-gray-300" />
  </div>
</template>
