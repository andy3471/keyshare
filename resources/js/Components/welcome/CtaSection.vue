<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { register } from '@/routes';
</script>

<template>
  <section class="relative py-20 sm:py-28 border-t border-dark-800">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-accent-600/5 via-transparent to-transparent" />
    <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="text-3xl sm:text-4xl font-display font-bold text-white mb-4">
        Ready to Share?
      </h2>
      <p class="text-gray-400 text-lg mb-8">
        Stop letting extra game keys go to waste. Create a group and start sharing today.
      </p>
      <Link
        :href="register.url()"
        class="inline-block bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-3 px-8 rounded-lg text-lg transition-all duration-200 shadow-lg shadow-accent-600/25 hover:shadow-xl hover:shadow-accent-600/35 hover:-translate-y-0.5 active:translate-y-0"
      >
        Create Your Account
      </Link>
    </div>
  </section>
</template>
