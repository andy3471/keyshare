<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import GroupAvatar from '@/Components/shared/GroupAvatar.vue';
import groups from '@/routes/groups';
import { GroupData } from '@/Types/generated';
import { UsersIcon } from '@heroicons/vue/24/outline';

interface Props {
  group: GroupData;
}

defineProps<Props>();
</script>

<template>
  <div class="bg-dark-800 rounded-xl p-5 border border-dark-700 hover:border-accent-600/50 transition-all">
    <div class="flex items-start gap-3 mb-3">
      <GroupAvatar
        :avatar="group.avatar"
        :name="group.name"
        size="md"
      />
      <div class="flex-1 min-w-0">
        <Link
          :href="groups.show.url(group.id)"
          class="text-lg font-semibold text-white hover:text-accent-400 transition-colors truncate block"
        >
          {{ group.name }}
        </Link>
      </div>
    </div>

    <p
      v-if="group.description"
      class="text-gray-400 text-sm mb-4 line-clamp-2"
    >
      {{ group.description }}
    </p>

    <div class="flex items-center justify-between">
      <span class="text-xs text-gray-500 flex items-center gap-1">
        <UsersIcon class="w-3.5 h-3.5" />
        {{ group.member_count }} {{ group.member_count === 1 ? 'member' : 'members' }}
      </span>
      <Link
        :href="groups.show.url(group.id)"
        class="text-sm text-accent-400 hover:text-accent-300 font-medium"
      >
        View Group
      </Link>
    </div>
  </div>
</template>
