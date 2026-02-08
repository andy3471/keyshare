<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { KeyData } from '@/Types/generated';
import keyRoutes from '@/routes/keys';

interface Props {
  keyData: KeyData;
}

defineProps<Props>();
</script>

<template>
  <Link
    :href="keyRoutes.show(keyData.id)"
    class="group relative bg-dark-800 rounded-lg border border-dark-700 overflow-hidden transition-all duration-300 hover:border-accent-500 hover:shadow-xl hover:shadow-accent-500/20 hover:-translate-y-1"
  >
    <div class="flex">
      <!-- Game Image -->
      <div class="flex-shrink-0 w-20 sm:w-24">
        <img
          v-if="keyData.game?.image"
          :src="keyData.game.image"
          :alt="keyData.game.name"
          class="w-full h-full object-cover"
        >
        <div
          v-else
          class="w-full h-full min-h-[120px] bg-dark-700 flex items-center justify-center"
        >
          <svg
            class="w-8 h-8 text-dark-500"
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
        </div>
      </div>

      <!-- Content -->
      <div class="flex-1 min-w-0 p-4">
        <!-- Game Name + Platform -->
        <div class="flex items-start justify-between gap-2 mb-2">
          <h3 class="text-white font-semibold truncate group-hover:text-accent-400 transition-colors">
            {{ keyData.game?.name || 'Unknown Game' }}
          </h3>
          <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-accent-600/20 text-accent-400 border border-accent-600/30 flex-shrink-0">
            {{ keyData.platform?.name || 'Unknown' }}
          </span>
        </div>

        <!-- Group -->
        <div
          v-if="keyData.group"
          class="flex items-center gap-2 mb-2"
        >
          <img
            v-if="keyData.group.avatar"
            :src="keyData.group.avatar"
            :alt="keyData.group.name"
            class="w-5 h-5 rounded object-cover flex-shrink-0"
          >
          <span
            v-else
            class="w-5 h-5 rounded bg-accent-600/20 flex items-center justify-center flex-shrink-0"
          >
            <span class="text-accent-400 text-[10px] font-bold">{{ keyData.group.name.charAt(0).toUpperCase() }}</span>
          </span>
          <span class="text-gray-400 text-sm truncate">{{ keyData.group.name }}</span>
        </div>

        <!-- Claimed By / Shared By -->
        <div
          v-if="keyData.claimedUser"
          class="flex items-center gap-2"
        >
          <img
            :src="keyData.claimedUser.avatar"
            :alt="keyData.claimedUser.name"
            class="w-5 h-5 rounded-full flex-shrink-0"
          >
          <span class="text-gray-500 text-xs truncate">
            Claimed by {{ keyData.claimedUser.name }}
          </span>
        </div>
        <div
          v-else-if="keyData.createdUser"
          class="flex items-center gap-2"
        >
          <img
            :src="keyData.createdUser.avatar"
            :alt="keyData.createdUser.name"
            class="w-5 h-5 rounded-full flex-shrink-0"
          >
          <span class="text-gray-500 text-xs truncate">
            Shared by {{ keyData.createdUser.name }}
          </span>
        </div>

        <!-- Status -->
        <div
          v-if="keyData.can?.claim"
          class="flex items-center gap-1 text-success text-xs font-medium mt-2"
        >
          <svg
            class="w-3.5 h-3.5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          <span>Available</span>
        </div>
        <div
          v-else
          class="flex items-center gap-1 text-gray-500 text-xs font-medium mt-2"
        >
          <svg
            class="w-3.5 h-3.5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7"
            />
          </svg>
          <span>Claimed</span>
        </div>
      </div>

      <!-- Arrow -->
      <div class="flex items-center pr-4 opacity-0 group-hover:opacity-100 transition-opacity">
        <svg
          class="w-5 h-5 text-accent-400"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 5l7 7-7 7"
          />
        </svg>
      </div>
    </div>
  </Link>
</template>
