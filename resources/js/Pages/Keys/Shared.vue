<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import UserKeyCard from '@/Components/UserKeyCard.vue';
import { KeyData } from '@/Types/generated';
import type { Paginated } from '@/types/global';

interface Props {
  keys: Paginated<KeyData>;
}

defineProps<Props>();
</script>

<template>
  <AppLayout title="Shared Keys">
    <Head title="Shared Keys" />

    <div
      v-if="keys.data.length > 0"
      class="grid grid-cols-1 lg:grid-cols-2 gap-4"
    >
      <UserKeyCard
        v-for="keyItem in keys.data"
        :key="keyItem.id"
        :key-data="keyItem"
      />
    </div>

    <div
      v-else
      class="bg-dark-800 rounded-lg border border-dark-700 p-12 text-center"
    >
      <svg
        class="w-16 h-16 text-dark-500 mx-auto mb-4"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="1.5"
          d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"
        />
      </svg>
      <p class="text-gray-400 text-lg">
        No shared keys yet
      </p>
      <p class="text-gray-500 text-sm mt-1">
        Keys you share will appear here
      </p>
    </div>
  </AppLayout>
</template>
