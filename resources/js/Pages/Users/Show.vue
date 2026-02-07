<script setup lang="ts">
import { Link, usePage, Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { UserData } from '@/Types/generated';
import users from '@/routes/users';
import keys from '@/routes/keys';
import type { AuthUser } from '@/types/global';

interface Props {
  user: UserData;
}

defineProps<Props>();

const page = usePage();
const auth = (page.props.auth as AuthUser | undefined) ?? { user: null };
</script>

<template>
  <AppLayout :title="user.name">
    <Head :title="user.name" />
    <div class="max-w-7xl mx-auto px-4 py-6">
      <!-- Profile Banner -->
      <div class="bg-gradient-to-r from-dark-800 via-dark-700 to-dark-800 rounded-lg border border-dark-700 p-8 mb-6 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
          <div
            class="absolute inset-0"
            style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(139, 92, 246, 0.1) 10px, rgba(139, 92, 246, 0.1) 20px);"
          />
        </div>

        <div class="relative flex flex-col md:flex-row items-start md:items-center gap-6">
          <!-- Avatar with Karma Badge -->
          <div class="relative flex-shrink-0">
            <img
              :src="user.avatar ?? ''"
              :alt="user.name"
              class="w-32 h-32 rounded-full border-4 border-dark-600 shadow-xl"
            >
            <div class="absolute -bottom-2 -right-2">
              <span
                :class="[
                  'inline-flex items-center px-4 py-2 rounded-full text-lg font-bold shadow-lg',
                  user.karma_colour === 'badge-danger' ? 'bg-danger text-white shadow-danger/50' :
                  user.karma_colour === 'badge-warning' ? 'bg-warning text-white shadow-warning/50' :
                  user.karma_colour === 'badge-info' ? 'bg-primary-600 text-white shadow-primary-600/50' :
                  'bg-success text-white shadow-success/50'
                ]"
              >
                {{ user.karma }}
              </span>
            </div>
          </div>

          <!-- User Info -->
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
                v-if="user.id === auth.user?.id"
                :href="users.edit.url(user.id)"
                class="bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5 active:translate-y-0 inline-flex items-center whitespace-nowrap"
              >
                <svg
                  class="w-5 h-5 mr-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                  />
                </svg>
                Edit Profile
              </Link>
            </div>
          </div>
        </div>
      </div>

      <!-- Stats Cards (only show for own profile) -->
      <div
        v-if="user.id === auth.user?.id"
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
              <svg
                class="w-8 h-8 text-accent-400"
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
              <svg
                class="w-8 h-8 text-primary-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"
                />
              </svg>
            </div>
          </div>
        </Link>
      </div>
    </div>
  </AppLayout>
</template>
