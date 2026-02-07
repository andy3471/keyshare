<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { register, login } from '@/routes';
</script>

<template>
  <GuestLayout>
    <Head title="Share Game Keys With Friends" />

    <!-- Hero Section -->
    <section class="relative overflow-hidden">
      <!-- Background effects -->
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

      <!-- Decorative gradient divider -->
      <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-accent-600/40 to-transparent" />
    </section>

    <!-- Features Section -->
    <section class="relative py-20 sm:py-28">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl sm:text-4xl font-display font-bold text-white mb-4">
            Everything Your Group Needs
          </h2>
          <p class="text-gray-400 text-lg max-w-2xl mx-auto">
            A simple, organized way to manage and share game keys within your community.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <!-- Create Groups -->
          <div class="group relative bg-dark-900/60 border border-dark-700 rounded-xl p-8 transition-all duration-300 hover:border-warning/50 hover:shadow-lg hover:shadow-warning/10">
            <div class="w-12 h-12 rounded-lg bg-warning/15 flex items-center justify-center mb-5">
              <svg
                class="w-6 h-6 text-warning"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-3">
              Create Groups
            </h3>
            <p class="text-gray-400 leading-relaxed">
              Set up a group for your friends, your Discord server, or any gaming community. Invite members and start sharing instantly.
            </p>
          </div>

          <!-- Share Keys -->
          <div class="group relative bg-dark-900/60 border border-dark-700 rounded-xl p-8 transition-all duration-300 hover:border-accent-500/50 hover:shadow-lg hover:shadow-accent-500/10">
            <div class="w-12 h-12 rounded-lg bg-accent-600/15 flex items-center justify-center mb-5">
              <svg
                class="w-6 h-6 text-accent-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-3">
              Share Keys
            </h3>
            <p class="text-gray-400 leading-relaxed">
              Easily add your extra game keys. Sparekey.club automatically looks up game details and cover art so everything looks great.
            </p>
          </div>

          <!-- Claim Games -->
          <div class="group relative bg-dark-900/60 border border-dark-700 rounded-xl p-8 transition-all duration-300 hover:border-primary-500/50 hover:shadow-lg hover:shadow-primary-500/10">
            <div class="w-12 h-12 rounded-lg bg-primary-600/15 flex items-center justify-center mb-5">
              <svg
                class="w-6 h-6 text-primary-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"
                />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-3">
              Claim Games
            </h3>
            <p class="text-gray-400 leading-relaxed">
              Browse available keys and claim the games you want. Keys are revealed only after claiming, so no one can snipe them.
            </p>
          </div>

          <!-- Community Karma -->
          <div class="group relative bg-dark-900/60 border border-dark-700 rounded-xl p-8 transition-all duration-300 hover:border-success/50 hover:shadow-lg hover:shadow-success/10">
            <div class="w-12 h-12 rounded-lg bg-success/15 flex items-center justify-center mb-5">
              <svg
                class="w-6 h-6 text-success"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-3">
              Community Karma
            </h3>
            <p class="text-gray-400 leading-relaxed">
              A built-in karma system keeps things fair. The more you share, the more karma you earn within your group.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- How It Works Section -->
    <section class="relative py-20 sm:py-28 border-t border-dark-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl sm:text-4xl font-display font-bold text-white mb-4">
            How It Works
          </h2>
          <p class="text-gray-400 text-lg max-w-2xl mx-auto">
            Get started in minutes. It's as simple as 1-2-3.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-4xl mx-auto">
          <!-- Step 1 -->
          <div class="text-center">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-accent-500 to-accent-700 flex items-center justify-center mx-auto mb-5 shadow-lg shadow-accent-600/30">
              <span class="text-white font-display font-bold text-xl">1</span>
            </div>
            <h3 class="text-lg font-semibold text-white mb-2">
              Create a Group
            </h3>
            <p class="text-gray-400 text-sm leading-relaxed">
              Sign up, create a group for your friends, and invite them with a link.
            </p>
          </div>

          <!-- Step 2 -->
          <div class="text-center">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center mx-auto mb-5 shadow-lg shadow-primary-600/30">
              <span class="text-white font-display font-bold text-xl">2</span>
            </div>
            <h3 class="text-lg font-semibold text-white mb-2">
              Share Your Keys
            </h3>
            <p class="text-gray-400 text-sm leading-relaxed">
              Search for the game, select the platform, and paste your key. Done.
            </p>
          </div>

          <!-- Step 3 -->
          <div class="text-center">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-success to-success-dark flex items-center justify-center mx-auto mb-5 shadow-lg shadow-success/30">
              <span class="text-white font-display font-bold text-xl">3</span>
            </div>
            <h3 class="text-lg font-semibold text-white mb-2">
              Friends Claim
            </h3>
            <p class="text-gray-400 text-sm leading-relaxed">
              Your friends browse available games and claim the keys they want.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
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

    <!-- Footer -->
    <footer class="border-t border-dark-800 py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center gap-3">
        <div class="flex items-center gap-4">
          <a
            href="https://github.com/andy3471/sparekey.club"
            target="_blank"
            rel="noopener noreferrer"
            class="text-gray-500 hover:text-gray-300 transition-colors"
            aria-label="GitHub"
          >
            <svg
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
              />
            </svg>
          </a>
          <a
            href="https://ko-fi.com/andy3471#payment-widget"
            target="_blank"
            rel="noopener noreferrer"
            class="text-gray-500 hover:text-gray-300 transition-colors"
            aria-label="Ko-fi"
          >
            <svg
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 24 24"
            >
              <path d="M23.881 8.948c-.773-4.085-4.859-4.593-4.859-4.593H.723c-.604 0-.679.798-.679.798s-.082 7.324-.022 11.822c.164 2.424 2.586 2.672 2.586 2.672s8.267-.023 11.966-.049c2.438-.426 2.683-2.566 2.658-3.734 4.352.24 7.422-2.831 6.649-6.916zm-11.062 3.511c-1.246 1.453-4.011 3.976-4.011 3.976s-.121.119-.31.023c-.076-.057-.108-.09-.108-.09-.443-.441-3.368-3.049-4.034-3.954-.709-.965-1.041-2.7-.091-3.71.951-1.01 3.005-1.086 4.363.407 0 0 1.565-1.782 3.468-.963 1.904.82 1.832 3.011.723 4.311zm6.173.478c-.928.116-1.682.028-1.682.028V7.284h1.77s1.971.551 1.971 2.638c0 1.913-.985 2.667-2.059 3.015z" />
            </svg>
          </a>
        </div>
        <p class="text-center text-gray-500 text-sm">
          &copy; {{ new Date().getFullYear() }} Sparekey.club.
        </p>
      </div>
    </footer>
  </GuestLayout>
</template>
