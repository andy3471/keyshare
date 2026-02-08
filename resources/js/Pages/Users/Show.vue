<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import UserAvatar from '@/Components/shared/UserAvatar.vue';
import GroupAvatar from '@/Components/shared/GroupAvatar.vue';
import { UserData, GroupData } from '@/Types/generated';
import type { AuthUser } from '@/types/global';
import users from '@/routes/users';
import keys from '@/routes/keys';
import groupRoutes from '@/routes/groups';
import {
  PencilSquareIcon,
  CheckBadgeIcon,
  ShareIcon,
  UserGroupIcon,
} from '@heroicons/vue/24/outline';

interface Props {
  user: UserData;
  groups: GroupData[];
}

const props = defineProps<Props>();

const page = usePage();
const auth = (page.props.auth as AuthUser | undefined) ?? { user: null };
const isOwnProfile = auth.user?.id === props.user.id;
</script>

<template>
  <AppLayout :title="user.name">
    <Head :title="user.name" />
    <div class="max-w-7xl mx-auto px-4 py-6">
      <div class="bg-gradient-to-r from-dark-800 via-dark-700 to-dark-800 rounded-lg border border-dark-700 p-8 mb-6 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
          <div
            class="absolute inset-0"
            style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(139, 92, 246, 0.1) 10px, rgba(139, 92, 246, 0.1) 20px);"
          />
        </div>

        <div class="relative flex flex-col md:flex-row items-start md:items-center gap-6">
          <UserAvatar
            :avatar="user.avatar"
            :name="user.name"
            :karma="user.karma"
            :karma-colour="user.karma_colour"
            size="xl"
          />

          <div class="flex-1">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
              <div>
                <h1 class="text-4xl font-bold text-white mb-2">
                  {{ user.name }}
                </h1>
                <p
                  v-if="user.bio"
                  class="text-gray-300 text-lg leading-relaxed max-w-2xl"
                >
                  {{ user.bio }}
                </p>
                <p
                  v-else
                  class="text-gray-500 italic"
                >
                  No bio yet
                </p>
              </div>
              <Link
                v-if="isOwnProfile"
                :href="users.edit.url(user.id)"
                class="bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5 active:translate-y-0 inline-flex items-center whitespace-nowrap"
              >
                <PencilSquareIcon class="w-5 h-5 mr-2" />
                Edit Profile
              </Link>
            </div>
          </div>
        </div>
      </div>

      <div
        v-if="isOwnProfile"
        class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6"
      >
        <Link
          :href="keys.claimed.index.url()"
          class="bg-dark-800 rounded-lg border border-dark-700 p-6 hover:border-accent-500 hover:shadow-lg hover:shadow-accent-500/20 transition-all duration-200 group"
        >
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-lg font-semibold text-gray-300 mb-1 group-hover:text-white transition-colors">
                Claimed Keys
              </h3>
              <p class="text-sm text-gray-500">
                View your claimed game keys
              </p>
            </div>
            <div class="bg-accent-600/20 rounded-lg p-4 group-hover:bg-accent-600/30 transition-colors">
              <CheckBadgeIcon class="w-8 h-8 text-accent-400" />
            </div>
          </div>
        </Link>

        <Link
          :href="keys.shared.index.url()"
          class="bg-dark-800 rounded-lg border border-dark-700 p-6 hover:border-accent-500 hover:shadow-lg hover:shadow-accent-500/20 transition-all duration-200 group"
        >
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-lg font-semibold text-gray-300 mb-1 group-hover:text-white transition-colors">
                Shared Keys
              </h3>
              <p class="text-sm text-gray-500">
                View your shared game keys
              </p>
            </div>
            <div class="bg-primary-600/20 rounded-lg p-4 group-hover:bg-primary-600/30 transition-colors">
              <ShareIcon class="w-8 h-8 text-primary-400" />
            </div>
          </div>
        </Link>
      </div>

      <div
        v-if="groups.length > 0"
        class="bg-dark-800 rounded-lg border border-dark-700 p-6"
      >
        <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
          <UserGroupIcon class="w-5 h-5 text-accent-400" />
          Groups
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
          <Link
            v-for="group in groups"
            :key="group.id"
            :href="groupRoutes.show.url(group.id)"
            class="flex items-center gap-3 p-3 rounded-lg border border-dark-600 hover:border-accent-500 hover:bg-dark-700 transition-all duration-200 group"
          >
            <GroupAvatar
              :avatar="group.avatar"
              :name="group.name"
              size="md"
            />
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-white truncate group-hover:text-accent-400 transition-colors">
                {{ group.name }}
              </p>
              <p class="text-xs text-gray-500">
                {{ group.member_count }} {{ group.member_count === 1 ? 'member' : 'members' }}
                <span
                  v-if="group.is_public"
                  class="ml-1 text-green-500"
                >· Public</span>
                <span
                  v-else
                  class="ml-1 text-yellow-500"
                >· Private</span>
              </p>
            </div>
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
