<script setup lang="ts">
import type { PendingGroup } from '@/Types/onboarding';

defineProps<{
  group: PendingGroup;
}>();
</script>

<template>
  <div class="flex items-center gap-3 p-3 rounded-lg bg-accent-600/10 border border-accent-600/20 mb-6">
    <div class="w-8 h-8 rounded-lg bg-dark-600 flex items-center justify-center flex-shrink-0 overflow-hidden">
      <img
        v-if="group.avatar"
        :src="group.avatar"
        :alt="group.name"
        class="w-full h-full object-cover"
      >
      <span
        v-else
        class="text-xs font-bold text-gray-400"
      >{{ group.name.charAt(0).toUpperCase() }}</span>
    </div>
    <div class="min-w-0">
      <p class="text-sm font-medium text-accent-400">
        You've been invited to join
      </p>
      <p class="text-sm font-semibold text-white truncate">
        {{ group.name }}
      </p>
    </div>
  </div>
</template>
