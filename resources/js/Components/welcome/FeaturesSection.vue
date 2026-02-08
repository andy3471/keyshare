<script setup lang="ts">
import { UserPlusIcon, PaperAirplaneIcon, TicketIcon, UsersIcon } from '@heroicons/vue/24/outline';
</script>

<template>
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
        <div class="group relative bg-dark-900/60 border border-dark-700 rounded-xl p-8 transition-all duration-300 hover:border-warning/50 hover:shadow-lg hover:shadow-warning/10">
          <div class="w-12 h-12 rounded-lg bg-warning/15 flex items-center justify-center mb-5">
            <UserPlusIcon class="w-6 h-6 text-warning" />
          </div>
          <h3 class="text-xl font-semibold text-white mb-3">
            Create Groups
          </h3>
          <p class="text-gray-400 leading-relaxed">
            Set up a group for your friends, your Discord server, or any gaming community. Invite members and start sharing instantly.
          </p>
        </div>

        <div class="group relative bg-dark-900/60 border border-dark-700 rounded-xl p-8 transition-all duration-300 hover:border-accent-500/50 hover:shadow-lg hover:shadow-accent-500/10">
          <div class="w-12 h-12 rounded-lg bg-accent-600/15 flex items-center justify-center mb-5">
            <PaperAirplaneIcon class="w-6 h-6 text-accent-400" />
          </div>
          <h3 class="text-xl font-semibold text-white mb-3">
            Share Keys
          </h3>
          <p class="text-gray-400 leading-relaxed">
            Easily add your extra game keys. Sparekey.club automatically looks up game details and cover art so everything looks great.
          </p>
        </div>

        <div class="group relative bg-dark-900/60 border border-dark-700 rounded-xl p-8 transition-all duration-300 hover:border-primary-500/50 hover:shadow-lg hover:shadow-primary-500/10">
          <div class="w-12 h-12 rounded-lg bg-primary-600/15 flex items-center justify-center mb-5">
            <TicketIcon class="w-6 h-6 text-primary-400" />
          </div>
          <h3 class="text-xl font-semibold text-white mb-3">
            Claim Games
          </h3>
          <p class="text-gray-400 leading-relaxed">
            Browse available keys and claim the games you want. Keys are revealed only after claiming, so no one can snipe them.
          </p>
        </div>

        <div class="group relative bg-dark-900/60 border border-dark-700 rounded-xl p-8 transition-all duration-300 hover:border-success/50 hover:shadow-lg hover:shadow-success/10">
          <div class="w-12 h-12 rounded-lg bg-success/15 flex items-center justify-center mb-5">
            <UsersIcon class="w-6 h-6 text-success" />
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
</template>
