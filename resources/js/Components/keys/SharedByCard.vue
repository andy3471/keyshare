<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import UserAvatar from '@/Components/shared/UserAvatar.vue';
import GroupAvatar from '@/Components/shared/GroupAvatar.vue';
import { UserData, GroupData } from '@/Types/generated';

interface Props {
  user: UserData;
  group?: GroupData | null;
}

defineProps<Props>();
</script>

<template>
  <div class="bg-dark-800 rounded-lg border border-dark-700 p-6">
    <h2 class="text-xl font-bold text-white mb-4">
      Shared By
    </h2>
    <div class="flex flex-col items-center text-center">
      <Link
        :href="`/users/${user.id}`"
        class="relative mb-4"
      >
        <UserAvatar
          :avatar="user.avatar"
          :name="user.name"
          :karma="user.karma ?? 0"
          :karma-colour="user.karma_colour ?? ''"
          size="lg"
          class="hover:border-accent-500 transition-colors"
        />
      </Link>
      <h3 class="text-lg font-semibold text-white mb-1">
        <Link
          :href="`/users/${user.id}`"
          class="text-accent-400 hover:text-accent-300 transition-colors"
        >
          {{ user.name }}
        </Link>
      </h3>
      <div
        v-if="group"
        class="flex items-center justify-center gap-2 mb-2"
      >
        <GroupAvatar
          :avatar="group.avatar"
          :name="group.name"
          size="xs"
        />
        <span class="text-gray-400 text-sm">{{ group.name }}</span>
      </div>
      <p
        v-if="user.bio"
        class="text-gray-400 text-sm"
      >
        {{ user.bio }}
      </p>
    </div>
  </div>
</template>
