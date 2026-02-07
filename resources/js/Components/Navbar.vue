<script setup lang="ts">
import { Link, useForm, usePage, router } from '@inertiajs/vue3';
import { logout as logoutRoute, login } from '@/routes';
import games from '@/routes/games';
import keys from '@/routes/keys';
import users from '@/routes/users';
import Autocomplete from './Autocomplete.vue';
import { AutocompleteGameData } from '@/Types/generated';
import type { AuthUser } from '@/types/global';

const page = usePage();
// Ensure auth is always defined, even if user is null
const auth = (page.props.auth as AuthUser | undefined) ?? { user: null };
const appName = 'Keyshare';

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

const logout = () => {
  const form = useForm({});
  form.post(logoutRoute.url());
};

const handleGameSelect = (item: AutocompleteGameData | null) => {
  if (item) {
    router.visit(games.show.url({ igdb_id: item.id }));
  }
};

const handleSearch = (query: string) => {
  // Navigate to the full search results page
  const trimmedQuery = query.trim();

  // Build URL manually to ensure search parameter is always included
  const baseUrl = '/search';
  const url = trimmedQuery
    ? `${baseUrl}?search=${encodeURIComponent(trimmedQuery)}`
    : `${baseUrl}?search=`;

  router.visit(url);
};
</script>

<template>
  <nav class="bg-dark-900/95 backdrop-blur-sm border-b-2 border-accent-600 sticky top-0 z-50 shadow-lg shadow-accent-600/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <Link
            :href="games.index.url()"
            class="text-white text-xl font-display font-bold hover:text-accent-400 transition-colors"
          >
            <span class="bg-gradient-to-r from-accent-400 to-primary-400 bg-clip-text text-transparent">{{ appName }}</span>
          </Link>
        </div>

        <div
          v-if="auth?.user"
          class="hidden lg:flex items-center space-x-2"
        >
          <!-- Games Link -->
          <Link
            :href="games.index.url()"
            class="text-gray-300 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-dark-800"
          >
            Games
          </Link>

          <!-- Add Key Link -->
          <Link
            :href="keys.create.url()"
            class="text-gray-300 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-dark-800"
          >
            Add Key
          </Link>

          <!-- Search -->
          <div class="flex items-center ml-2">
            <div class="relative w-64">
              <Autocomplete
                id="navbar-search"
                name="search"
                placeholder="Search games..."
                url="/autocomplete"
                input-class="w-64 pl-10 pr-4 py-2 bg-dark-800 border border-dark-600 text-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500"
                @update:model-value="handleGameSelect"
                @search="handleSearch"
              />
              <svg
                class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400 pointer-events-none"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                />
              </svg>
            </div>
          </div>

          <!-- User Dropdown -->
          <div class="relative group">
            <button class="flex items-center space-x-2 text-gray-300 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-dark-800">
              <div class="relative">
                <img
                  :src="auth?.user?.avatar"
                  :alt="auth?.user?.name"
                  class="h-8 w-8 rounded-full border-2 border-dark-600 group-hover:border-accent-500 transition-colors"
                >
                <div class="absolute -bottom-1 -right-1">
                  <span
                    :class="[
                      'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold shadow-md',
                      auth?.user?.karma_colour === 'badge-danger' ? 'bg-danger text-white shadow-danger/30' :
                      auth?.user?.karma_colour === 'badge-warning' ? 'bg-warning text-white shadow-warning/30' :
                      auth?.user?.karma_colour === 'badge-info' ? 'bg-primary-600 text-white shadow-primary-600/30' :
                      'bg-success text-white shadow-success/30'
                    ]"
                  >
                    {{ auth?.user?.karma }}
                  </span>
                </div>
              </div>
              <span class="hidden xl:inline">{{ auth?.user?.name }}</span>
              <svg
                class="h-4 w-4 transition-transform duration-200 group-hover:rotate-180"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                />
              </svg>
            </button>
            <div class="absolute right-0 mt-2 w-56 bg-dark-800 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-dark-700 overflow-hidden">
              <div class="py-1">
                <Link
                  v-if="auth?.user?.id"
                  :href="users.show.url(auth.user.id)"
                  class="block px-4 py-2 text-sm text-gray-300 hover:bg-accent-600 hover:text-white transition-colors"
                >
                  View Profile
                </Link>
                <Link
                  v-if="auth?.user?.id"
                  :href="users.edit.url(auth.user.id)"
                  class="block px-4 py-2 text-sm text-gray-300 hover:bg-accent-600 hover:text-white transition-colors"
                >
                  Update Profile
                </Link>
                <Link
                  v-if="auth?.user?.admin"
                  href="/admin"
                  class="block px-4 py-2 text-sm text-gray-300 hover:bg-accent-600 hover:text-white transition-colors"
                >
                  Admin
                </Link>
                <div class="border-t border-dark-700 my-1" />
                <Link
                  :href="keys.claimed.index.url()"
                  class="block px-4 py-2 text-sm text-gray-300 hover:bg-accent-600 hover:text-white transition-colors"
                >
                  Claimed Keys
                </Link>
                <Link
                  :href="keys.shared.index.url()"
                  class="block px-4 py-2 text-sm text-gray-300 hover:bg-accent-600 hover:text-white transition-colors"
                >
                  Shared Keys
                </Link>
                <div class="border-t border-dark-700 my-1" />
                <form
                  :action="logoutRoute.url()"
                  method="POST"
                  @submit.prevent="logout"
                >
                  <input
                    type="hidden"
                    name="_token"
                    :value="csrfToken"
                  >
                  <button
                    type="submit"
                    class="w-full text-left block px-4 py-2 text-sm text-gray-300 hover:bg-danger-600 hover:text-white transition-colors"
                  >
                    Logout
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div
          v-else
          class="flex items-center space-x-4"
        >
          <Link
            :href="login.url()"
            class="text-gray-300 hover:text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-dark-800"
          >
            Login
          </Link>
        </div>
      </div>
    </div>
  </nav>
</template>
