<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import UserAvatar from '@/Components/shared/UserAvatar.vue';
import UserKeyCard from '@/Components/keys/UserKeyCard.vue';
import EmptyState from '@/Components/shared/EmptyState.vue';
import { KeyData, UserData } from '@/Types/generated';
import type { AuthUser } from '@/types/global';
import users from '@/routes/users';
import { PencilIcon, KeyIcon } from '@heroicons/vue/24/outline';

interface Props {
  user: UserData;
  keys: KeyData[];
}

const props = defineProps<Props>();

const page = usePage();
const auth = (page.props.auth as AuthUser | undefined) ?? { user: null };
const isOwnProfile = auth.user?.id === props.user.id;
</script>

<template>
  <AppLayout :title="user.name">
    <Head :title="user.name" />
    <div class="max-w-5xl mx-auto px-4 py-6 space-y-6">
      <div class="bg-dark-800 rounded-xl p-6 border border-dark-700">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
          <UserAvatar
            :avatar="user.avatar"
            :name="user.name"
            :karma="user.karma"
            :karma-colour="user.karma_colour"
            size="lg"
          />
          <div class="flex-1 text-center sm:text-left">
            <div class="flex items-center justify-center sm:justify-start gap-3 mb-2">
              <h1 class="text-2xl font-display font-bold text-white">
                {{ user.name }}
              </h1>
              <Link
                v-if="isOwnProfile"
                :href="users.edit.url(user.id)"
                class="text-gray-500 hover:text-accent-400 transition-colors"
              >
                <PencilIcon class="w-4 h-4" />
              </Link>
            </div>
            <p
              v-if="user.bio"
              class="text-gray-400"
            >
              {{ user.bio }}
            </p>
            <p
              v-else
              class="text-gray-500 italic text-sm"
            >
              No bio yet
            </p>
          </div>
        </div>
      </div>

      <div>
        <h2 class="text-xl font-display font-bold text-white mb-4">
          Shared Keys
        </h2>
        <div
          v-if="keys.length > 0"
          class="space-y-3"
        >
          <UserKeyCard
            v-for="keyData in keys"
            :key="keyData.id"
            :key-data="keyData"
          />
        </div>
        <EmptyState
          v-else
          :title="isOwnProfile ? 'No shared keys yet' : `${user.name} hasn't shared any keys yet`"
          :message="isOwnProfile ? 'Share a key to get started!' : ''"
        >
          <template #icon>
            <KeyIcon class="w-16 h-16 text-gray-600" />
          </template>
        </EmptyState>
      </div>
    </div>
  </AppLayout>
</template>
