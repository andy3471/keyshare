<script setup lang="ts">
import { ref } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import { login } from '@/routes';
import games from '@/routes/games';
import keys from '@/routes/keys';
import groupRoutes from '@/routes/groups';
import NavSearchBar from '@/Components/navbar/NavSearchBar.vue';
import NavUserDropdown from '@/Components/navbar/NavUserDropdown.vue';
import NavMobileMenu from '@/Components/navbar/NavMobileMenu.vue';
import GroupSwitcher from '@/Components/navbar/GroupSwitcher.vue';
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';
import type { AuthUser } from '@/types/global';
import type { ComboboxItem } from '@/types/ui';

const page = usePage();
const auth = (page.props.auth as AuthUser | undefined) ?? { user: null };
const appName = 'Sparekey.club';
const mobileMenuOpen = ref(false);

const handleGameSelect = (item: ComboboxItem) => {
  mobileMenuOpen.value = false;
  router.visit(games.show.url({ igdb_id: item.id }));
};

const handleSearch = (query: string) => {
  mobileMenuOpen.value = false;
  const trimmed = query.trim();
  router.visit(trimmed ? `/search?search=${encodeURIComponent(trimmed)}` : '/search?search=');
};
</script>

<template>
  <nav class="bg-dark-900/95 backdrop-blur-sm border-b-2 border-accent-600 sticky top-0 z-50 shadow-lg shadow-accent-600/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center h-16">
        <Link
          :href="games.index.url()"
          class="text-white text-xl font-display font-bold hover:text-accent-400 transition-colors flex-shrink-0"
        >
          <span class="bg-gradient-to-r from-accent-400 to-primary-400 bg-clip-text text-transparent">{{ appName }}</span>
        </Link>

        <div
          v-if="auth?.user"
          class="hidden lg:flex items-center gap-1 ml-8"
        >
          <Link
            :href="games.index.url()"
            class="text-gray-300 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-dark-800"
          >
            Games
          </Link>
          <Link
            :href="groupRoutes.index.url()"
            class="text-gray-300 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-dark-800"
          >
            Groups
          </Link>
          <Link
            :href="keys.create.url()"
            class="text-gray-300 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-dark-800"
          >
            Add Key
          </Link>
        </div>

        <div class="flex-1" />

        <div
          v-if="auth?.user"
          class="hidden lg:flex items-center gap-3"
        >
          <NavSearchBar
            id="navbar-search"
            input-class="w-56 xl:w-64 pl-10 pr-4 py-2 bg-dark-800 border border-dark-600 text-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500"
            @select="handleGameSelect"
            @search="handleSearch"
          />
          <GroupSwitcher />
          <NavUserDropdown :user="auth.user" />
        </div>

        <Link
          v-if="!auth?.user"
          :href="login.url()"
          class="hidden lg:inline-flex text-gray-300 hover:text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-dark-800"
        >
          Login
        </Link>

        <button
          v-if="auth?.user"
          class="lg:hidden flex items-center justify-center p-2 rounded-lg text-gray-300 hover:text-white hover:bg-dark-800 transition-all duration-200 ml-3"
          @click="mobileMenuOpen = !mobileMenuOpen"
        >
          <Bars3Icon
            v-if="!mobileMenuOpen"
            class="w-6 h-6"
          />
          <XMarkIcon
            v-else
            class="w-6 h-6"
          />
        </button>
      </div>
    </div>

    <NavMobileMenu
      v-if="auth?.user && mobileMenuOpen"
      :user="auth.user"
      @close="mobileMenuOpen = false"
      @select="handleGameSelect"
      @search="handleSearch"
    />
  </nav>
</template>
