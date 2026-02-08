<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { register, login } from '@/routes';
</script>

<template>
  <section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-dark-950 via-dark-900 to-dark-950" />
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-accent-600/10 via-transparent to-transparent" />
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,_var(--tw-gradient-stops))] from-primary-600/10 via-transparent to-transparent" />

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-28 sm:pt-28 sm:pb-36">
      <div class="text-center max-w-3xl mx-auto">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-display font-bold tracking-tight mb-6">
          <span class="text-white">Share Your </span>
          <span class="bg-gradient-to-r from-accent-400 via-accent-300 to-primary-400 bg-clip-text text-transparent">Game Keys</span>
          <span class="text-white"> With Friends</span>
        </h1>
        <p class="text-lg sm:text-xl text-gray-400 mb-10 max-w-2xl mx-auto leading-relaxed">
          Got extra game keys from bundles? Create a group, invite your friends, and share keys in one place. No more spreadsheets or messy chat messages.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
          <Link
            :href="register.url()"
            class="w-full sm:w-auto bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-3 px-8 rounded-lg text-lg transition-all duration-200 shadow-lg shadow-accent-600/25 hover:shadow-xl hover:shadow-accent-600/35 hover:-translate-y-0.5 active:translate-y-0"
          >
            Get Started Free
          </Link>
          <Link
            :href="login.url()"
            class="w-full sm:w-auto text-gray-300 hover:text-white font-medium py-3 px-8 rounded-lg text-lg transition-all duration-200 border border-dark-600 hover:border-dark-500 hover:bg-dark-800/50"
          >
            Sign In
          </Link>
        </div>
      </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-accent-600/40 to-transparent" />
  </section>
</template>
