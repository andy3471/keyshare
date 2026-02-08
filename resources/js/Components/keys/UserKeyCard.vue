<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { KeyData } from '@/Types/generated';
import keyRoutes from '@/routes/keys';
import GroupAvatar from '@/Components/shared/GroupAvatar.vue';
import GameImagePlaceholder from '@/Components/shared/GameImagePlaceholder.vue';
import KeyStatusBadge from '@/Components/shared/KeyStatusBadge.vue';
import FeedbackBadge from '@/Components/shared/FeedbackBadge.vue';
import { ChevronRightIcon } from '@heroicons/vue/20/solid';

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
      <div class="flex-shrink-0 w-20 sm:w-24">
        <img
          v-if="keyData.game?.image"
          :src="keyData.game.image"
          :alt="keyData.game.name"
          class="w-full h-full object-cover"
        >
        <GameImagePlaceholder
          v-else
          size="sm"
        />
      </div>

      <div class="flex-1 min-w-0 p-4">
        <div class="flex items-start justify-between gap-2 mb-2">
          <h3 class="text-white font-semibold truncate group-hover:text-accent-400 transition-colors">
            {{ keyData.game?.name || 'Unknown Game' }}
          </h3>
          <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-accent-600/20 text-accent-400 border border-accent-600/30 flex-shrink-0">
            {{ keyData.platform?.name || 'Unknown' }}
          </span>
        </div>

        <div
          v-if="keyData.group"
          class="flex items-center gap-2 mb-2"
        >
          <GroupAvatar
            :avatar="keyData.group.avatar"
            :name="keyData.group.name"
            size="xs"
          />
          <span class="text-gray-400 text-sm truncate">{{ keyData.group.name }}</span>
        </div>

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

        <div class="flex items-center gap-3 mt-2">
          <KeyStatusBadge :can-claim="!!keyData.can?.claim" />
          <FeedbackBadge
            :feedback="keyData.feedback ?? null"
            :has-claimer="!!keyData.claimedUser"
          />
        </div>
      </div>

      <div class="flex items-center pr-4 opacity-0 group-hover:opacity-100 transition-opacity">
        <ChevronRightIcon class="w-5 h-5 text-accent-400" />
      </div>
    </div>
  </Link>
</template>
