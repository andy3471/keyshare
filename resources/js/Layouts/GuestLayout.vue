<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { login, register } from '@/routes';
import type { AuthUser } from '@/types/global';

const page = usePage();
const auth = (page.props.auth as AuthUser | undefined) ?? { user: null };
const appName = 'Keyshare';
</script>

<template>
  <div class="min-h-screen bg-dark-950">
    <nav class="bg-dark-900/80 backdrop-blur-sm border-b border-dark-800 sticky top-0 z-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <Link
            href="/"
            class="text-xl font-display font-bold"
          >
            <span class="bg-gradient-to-r from-accent-400 to-primary-400 bg-clip-text text-transparent">{{ appName }}</span>
          </Link>

          <div class="flex items-center space-x-3">
            <template v-if="!auth?.user">
              <Link
                :href="login.url()"
                class="text-gray-300 hover:text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-dark-800"
              >
                Login
              </Link>
              <Link
                :href="register.url()"
                class="bg-accent-600 hover:bg-accent-700 text-white font-semibold py-2 px-5 rounded-lg text-sm transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5"
              >
                Get Started
              </Link>
            </template>
          </div>
        </div>
      </div>
    </nav>

    <main>
      <slot />
    </main>
  </div>
</template>
