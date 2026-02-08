<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppFooter from '@/Components/layout/AppFooter.vue';
import FlashMessages from '@/Components/layout/FlashMessages.vue';
import { welcome } from '@/routes';
</script>

<template>
  <div class="min-h-screen flex flex-col bg-dark-950">
    <div class="flex-1 flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div class="w-full max-w-md">
        <div class="text-center mb-8">
          <Link
            :href="welcome.url()"
            class="inline-block"
          >
            <h1 class="text-3xl font-display font-bold bg-gradient-to-r from-accent-400 to-primary-400 bg-clip-text text-transparent">
              Sparekey.club
            </h1>
          </Link>
        </div>

        <div class="bg-dark-800 rounded-xl shadow-2xl shadow-dark-950/50 p-8 border border-dark-700">
          <slot />
        </div>
      </div>
    </div>

    <FlashMessages />
    <AppFooter />
  </div>
</template>
