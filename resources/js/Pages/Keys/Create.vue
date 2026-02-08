<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AddKey from '@/Components/keys/AddKey.vue';
import { AutocompleteGameData, GroupData, PlatformData } from '@/Types/generated';

interface Props {
  canCreate: boolean;
  platforms: PlatformData[];
  game?: AutocompleteGameData | null;
  groups: GroupData[];
  activeGroupId?: string | null;
}

defineProps<Props>();
</script>

<template>
  <AppLayout title="Add Key">
    <Head title="Add Key" />
    <div class="max-w-4xl mx-auto px-4 py-6">
      <template v-if="canCreate">
        <AddKey
          :platforms="platforms"
          :game="game"
          :groups="groups"
          :active-group-id="activeGroupId"
        />
      </template>

      <div
        v-else
        class="text-center py-16"
      >
        <svg
          class="w-16 h-16 mx-auto text-gray-600 mb-4"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="1.5"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"
          />
        </svg>
        <h2 class="text-xl font-semibold text-white mb-2">
          Join a Group First
        </h2>
        <p class="text-gray-400 mb-6 max-w-sm mx-auto">
          You need to be a member of at least one group before you can share game keys.
        </p>
        <Link
          href="/groups"
          class="inline-flex items-center px-5 py-2.5 bg-accent-600 hover:bg-accent-700 text-white font-medium rounded-lg transition-colors text-sm"
        >
          Browse Groups
        </Link>
      </div>
    </div>
  </AppLayout>
</template>
