<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { Link, useForm, usePage, Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { KeyData } from '@/Types/generated';
import type { FlashProps } from '@/types/global';
import keys from '@/routes/keys';
import games from '@/routes/games';

interface Props {
  keyData: KeyData;
}

const props = defineProps<Props>();

const keyData = computed(() => props.keyData);

const page = usePage();
const flash = (page.props.flash as FlashProps | undefined) ?? {};

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
const copied = ref(false);

const form = useForm({
  id: keyData.value.id,
});

watch(() => keyData.value.id, (newId) => {
  form.id = newId;
});

const copyKeyCode = async () => {
  if (!keyData.value.key) return;

  try {
    await navigator.clipboard.writeText(keyData.value.key);
    copied.value = true;
    setTimeout(() => {
      copied.value = false;
    }, 2000);
  } catch {
    const input = document.getElementById(`keycode-${keyData.value.id}`) as HTMLInputElement | null;
    if (input != null) {
      input.select();
      input.setSelectionRange(0, 99999);
      document.execCommand('copy');
      copied.value = true;
      setTimeout(() => {
        copied.value = false;
      }, 2000);
    }
  }
};

const claimKey = () => {
  if (!keyData.value.id) return;

  form.post(keys.claim.url(keyData.value.id), {
    preserveScroll: true,
  });
};
</script>

<template>
  <AppLayout
    v-if="keyData"
    :title="keyData.game?.name || 'Key'"
  >
    <Head :title="`${keyData.game?.name || 'Key'} - ${keyData.platform?.name || 'Key'}`" />
    <div class="max-w-7xl mx-auto px-4 py-6">
      <!-- Flash Messages -->
      <div
        v-if="flash.error"
        class="mb-6 bg-red-900/50 border border-red-700 rounded-lg p-4 text-red-300"
      >
        {{ flash.error }}
      </div>
      <div
        v-if="flash.message"
        class="mb-6 bg-green-900/50 border border-green-700 rounded-lg p-4 text-green-300"
      >
        {{ flash.message }}
      </div>

      <!-- Game Information Section -->
      <div
        v-if="keyData.game"
        class="mb-8"
      >
        <div class="bg-dark-800 rounded-lg border border-dark-700 p-6">
          <div class="flex flex-col lg:flex-row gap-6">
            <!-- Game Image -->
            <div class="flex-shrink-0">
              <Link
                :href="games.show.url(keyData.game.id)"
                class="block"
              >
                <div class="w-[180px]">
                  <img
                    v-if="keyData.game.image"
                    :src="keyData.game.image"
                    :alt="keyData.game.name"
                    class="w-full rounded-lg border border-dark-700 object-cover aspect-[2/3] hover:border-accent-500 transition-colors"
                  >
                  <div
                    v-else
                    class="w-full rounded-lg aspect-[2/3] flex items-center justify-center bg-gradient-to-br from-dark-800 via-dark-700 to-dark-800 border-2 border-accent-600/30"
                  >
                    <svg
                      class="w-16 h-16 text-accent-500/50"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M14.752 11.168l-3.197-2.132A1 1 0 0011 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                      />
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </div>
                </div>
              </Link>
            </div>

            <!-- Game Details -->
            <div class="flex-1">
              <Link
                :href="games.show.url(keyData.game.id)"
                class="block mb-4"
              >
                <h1 class="text-3xl font-bold text-white hover:text-accent-400 transition-colors mb-2">
                  {{ keyData.game.name }}
                </h1>
              </Link>

              <div
                v-if="keyData.game.description"
                class="text-gray-300 mb-4"
              >
                <p class="text-sm leading-relaxed line-clamp-4">
                  {{ keyData.game.description }}
                </p>
              </div>

              <div
                v-if="keyData.platform?.name"
                class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600/20 border border-primary-600/30 rounded-lg"
              >
                <svg
                  class="w-5 h-5 text-primary-400"
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
                <span class="text-primary-300 font-semibold text-lg">{{ keyData.platform.name }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Key Details Section -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Key Code & Claim Section -->
        <div class="lg:col-span-2 bg-dark-800 rounded-lg border border-dark-700 p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-white">
              Key Details
            </h2>
            <div
              v-if="keyData.platform?.name"
              class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary-600/20 border border-primary-600/30 rounded-lg"
            >
              <svg
                class="w-4 h-4 text-primary-400"
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
              <span class="text-primary-300 font-semibold">{{ keyData.platform.name }}</span>
            </div>
          </div>

          <form
            class="space-y-4"
            @submit.prevent="claimKey"
          >
            <input
              type="hidden"
              name="_token"
              :value="csrfToken"
            >
            <input
              type="hidden"
              name="id"
              :value="keyData.id"
            >

            <div
              v-if="keyData.can.claim"
              class="space-y-4"
            >
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Key Code</label>
                <input
                  name="key"
                  class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full opacity-60 cursor-not-allowed font-mono text-lg tracking-wider"
                  type="text"
                  value="*****-*****-*****-*****"
                  disabled
                >
              </div>
              <button
                type="submit"
                class="w-full bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5 active:translate-y-0"
              >
                Claim Key
              </button>
              <p class="text-gray-400 text-sm text-center">
                Click to claim this key
              </p>
            </div>

            <div
              v-else-if="keyData.key"
              class="space-y-4"
            >
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Your Key Code</label>
                <div class="relative">
                  <input
                    :id="`keycode-${keyData.id}`"
                    name="key"
                    readonly
                    class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 w-full font-mono text-lg tracking-wider cursor-text select-all"
                    type="text"
                    :value="keyData.key"
                  >
                  <button
                    type="button"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-dark-700 hover:bg-dark-600 text-gray-300 hover:text-white p-2 rounded-lg transition-colors"
                    :title="copied ? 'Copied!' : 'Copy to clipboard'"
                    @click="copyKeyCode"
                  >
                    <svg
                      v-if="!copied"
                      class="w-5 h-5"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                      />
                    </svg>
                    <svg
                      v-else
                      class="w-5 h-5 text-green-400"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                      />
                    </svg>
                  </button>
                </div>
              </div>
              <a
                v-if="keyData.platform?.name === 'Steam'"
                :href="`https://store.steampowered.com/account/registerkey?key=${keyData.key}`"
                target="_blank"
                class="block w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 text-center shadow-lg shadow-primary-600/20 hover:shadow-xl hover:shadow-primary-600/30 hover:-translate-y-0.5"
              >
                Redeem on Steam
              </a>
            </div>

            <div
              v-else
              class="space-y-4"
            >
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Key Code</label>
                <input
                  name="key"
                  class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full opacity-60 cursor-not-allowed font-mono text-lg tracking-wider"
                  type="text"
                  value="*****-*****-*****-*****"
                  disabled
                >
              </div>
              <button
                type="submit"
                class="w-full bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 opacity-50 cursor-not-allowed"
                disabled
              >
                Claim Key
              </button>
              <p class="text-gray-400 text-sm text-center">
                This key has already been claimed
              </p>
            </div>
          </form>
        </div>

        <!-- Shared By Section -->
        <div class="bg-dark-800 rounded-lg border border-dark-700 p-6">
          <h2 class="text-xl font-bold text-white mb-4">
            Shared By
          </h2>
          <div class="flex flex-col items-center text-center">
            <Link
              :href="`/users/${keyData.createdUser?.id}`"
              class="relative mb-4"
            >
              <img
                :src="keyData.createdUser?.avatar"
                :alt="keyData.createdUser?.name"
                class="w-24 h-24 rounded-full border-2 border-dark-600 hover:border-accent-500 transition-colors"
              >
              <div class="absolute -bottom-2 -right-2">
                <span
                  :class="[
                    'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold shadow-md',
                    keyData.createdUser?.karma_colour === 'badge-danger' ? 'bg-danger text-white shadow-danger/30' :
                    keyData.createdUser?.karma_colour === 'badge-warning' ? 'bg-warning text-white shadow-warning/30' :
                    keyData.createdUser?.karma_colour === 'badge-info' ? 'bg-primary-600 text-white shadow-primary-600/30' :
                    'bg-success text-white shadow-success/30'
                  ]"
                >
                  {{ keyData.createdUser?.karma }}
                </span>
              </div>
            </Link>
            <h3 class="text-lg font-semibold text-white mb-1">
              <Link
                :href="`/users/${keyData.createdUser?.id}`"
                class="text-accent-400 hover:text-accent-300 transition-colors"
              >
                {{ keyData.createdUser?.name }}
              </Link>
            </h3>
            <div
              v-if="keyData.group"
              class="flex items-center justify-center gap-2 mb-2"
            >
              <img
                v-if="keyData.group.avatar"
                :src="keyData.group.avatar"
                :alt="keyData.group.name"
                class="w-5 h-5 rounded object-cover"
              >
              <span
                v-else
                class="w-5 h-5 rounded bg-accent-600/20 flex items-center justify-center"
              >
                <span class="text-accent-400 text-[10px] font-bold">{{ keyData.group.name.charAt(0).toUpperCase() }}</span>
              </span>
              <span class="text-gray-400 text-sm">{{ keyData.group.name }}</span>
            </div>
            <p
              v-if="keyData.createdUser?.bio"
              class="text-gray-400 text-sm"
            >
              {{ keyData.createdUser.bio }}
            </p>
          </div>
        </div>
      </div>

      <!-- Message Section -->
      <div
        v-if="keyData.message"
        class="bg-dark-800 rounded-lg border border-dark-700 p-6"
      >
        <h2 class="text-xl font-bold text-white mb-3">
          Message from Sharer
        </h2>
        <p class="text-gray-300 leading-relaxed">
          {{ keyData.message }}
        </p>
      </div>
    </div>
  </AppLayout>
  <AppLayout
    v-else
    title="Loading..."
  >
    <div class="max-w-7xl mx-auto px-4 py-6">
      <div class="bg-dark-800 rounded-lg border border-dark-700 p-12 text-center">
        <div class="inline-flex flex-col items-center space-y-4">
          <div class="w-16 h-16 border-4 border-accent-600 border-t-transparent rounded-full animate-spin" />
          <p class="text-gray-400">
            Loading key...
          </p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
