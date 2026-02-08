<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { KeyData } from '@/Types/generated';
import keyRoutes from '@/routes/keys';
import UserAvatar from '@/Components/shared/UserAvatar.vue';
import GroupAvatar from '@/Components/shared/GroupAvatar.vue';
import KeyStatusBadge from '@/Components/shared/KeyStatusBadge.vue';
import PlatformIcon from '@/Components/shared/PlatformIcon.vue';

interface Props {
  keyData: KeyData;
}

defineProps<Props>();
</script>

<template>
  <Link
    :href="keyRoutes.show(keyData.id)"
    class="group relative bg-dark-800 rounded-lg border border-dark-700 p-4 transition-all duration-300 hover:border-accent-500 hover:shadow-xl hover:shadow-accent-500/20 hover:-translate-y-1"
  >
    <div class="flex items-center justify-between mb-3">
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold bg-accent-600/20 text-accent-400 border border-accent-600/30">
        <PlatformIcon
          :icon="keyData.platform?.icon || 'generic'"
          size="sm"
        />
        {{ keyData.platform?.name || 'Unknown Platform' }}
      </span>
      <KeyStatusBadge
        :can-claim="keyData.can.claim"
        :claim-denied-reason="keyData.can.claimDeniedReason"
      />
    </div>

    <div class="flex items-center space-x-3">
      <UserAvatar
        :avatar="keyData.createdUser?.avatar"
        :name="keyData.createdUser?.name || 'Unknown User'"
        :karma="keyData.createdUser?.karma || 0"
        :karma-colour="keyData.createdUser?.karma_colour || ''"
        size="md"
        class="group-hover:border-accent-500"
      />
      <div class="flex-1 min-w-0">
        <p class="text-white font-medium truncate group-hover:text-accent-400 transition-colors">
          {{ keyData.createdUser?.name || 'Unknown User' }}
        </p>
        <div
          v-if="keyData.group"
          class="flex items-center gap-1.5 mt-1"
        >
          <GroupAvatar
            :avatar="keyData.group.avatar"
            :name="keyData.group.name"
            size="xs"
          />
          <span class="text-gray-400 text-xs truncate">{{ keyData.group.name }}</span>
        </div>
        <p
          v-if="keyData.message"
          class="text-gray-400 text-sm truncate mt-1"
        >
          {{ keyData.message }}
        </p>
      </div>
    </div>
  </Link>
</template>
