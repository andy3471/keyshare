<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import UserKeyCard from '@/Components/keys/UserKeyCard.vue';
import EmptyState from '@/Components/shared/EmptyState.vue';
import { KeyData } from '@/Types/generated';
import type { Paginated } from '@/types/global';
import { TicketIcon } from '@heroicons/vue/24/outline';

interface Props {
  keys: Paginated<KeyData>;
}

defineProps<Props>();
</script>

<template>
  <AppLayout title="Claimed Keys">
    <Head title="Claimed Keys" />

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

    <EmptyState
      v-else
      title="No claimed keys yet"
      message="Keys you claim will appear here"
    >
      <template #icon>
        <TicketIcon class="w-16 h-16 text-dark-500" />
      </template>
    </EmptyState>
  </AppLayout>
</template>
