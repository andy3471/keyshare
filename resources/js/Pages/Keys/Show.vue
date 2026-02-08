<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { Link, useForm, usePage, Head, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { KeyData, KeyFeedback } from '@/Types/generated';
import type { FlashProps } from '@/types/global';
import { claim as claimRoute, feedback as feedbackRoute } from '@/routes/keys';
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

  form.post(claimRoute.url(keyData.value.id), {
    preserveScroll: true,
  });
};

const submitFeedback = (value: KeyFeedback) => {
  router.post(feedbackRoute.url(keyData.value.id), {
    feedback: value,
  }, {
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
              v-if="keyData.can?.claim"
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

            <!-- Own key -->
            <div
              v-else-if="keyData.can?.claimDeniedReason === 'own_key'"
              class="space-y-4"
            >
              <div class="bg-primary-600/10 border border-primary-600/30 rounded-lg p-4">
                <div class="flex items-start gap-3">
                  <svg
                    class="w-5 h-5 text-primary-400 flex-shrink-0 mt-0.5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                  <div>
                    <p class="text-primary-300 font-medium text-sm">
                      This is your key
                    </p>
                    <p class="text-gray-400 text-sm mt-1">
                      You shared this key — you can't claim your own.
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Karma too low -->
            <div
              v-else-if="keyData.can?.claimDeniedReason === 'karma_too_low'"
              class="space-y-4"
            >
              <div class="bg-warning/10 border border-warning/30 rounded-lg p-4">
                <div class="flex items-start gap-3">
                  <svg
                    class="w-5 h-5 text-warning flex-shrink-0 mt-0.5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                    />
                  </svg>
                  <div>
                    <p class="text-warning font-medium text-sm">
                      Karma too low
                    </p>
                    <p class="text-gray-400 text-sm mt-1">
                      This group requires a minimum karma of <span class="text-white font-semibold">{{ keyData.group?.min_karma }}</span> to claim keys. Share keys and get positive feedback to increase your karma.
                    </p>
                  </div>
                </div>
              </div>
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

              <!-- Feedback Section -->
              <div
                v-if="keyData.can?.feedback"
                class="pt-4 border-t border-dark-700"
              >
                <p class="text-sm text-gray-400 mb-3 text-center">
                  Did this key work?
                </p>
                <div
                  v-if="keyData.feedback === null"
                  class="flex items-center justify-center gap-4"
                >
                  <button
                    type="button"
                    class="group relative flex items-center gap-2 px-5 py-2.5 bg-success/10 border border-success/30 rounded-lg text-success hover:bg-success/20 hover:border-success/50 transition-all duration-200"
                    @click="submitFeedback('worked')"
                  >
                    <svg
                      class="w-5 h-5"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"
                      />
                    </svg>
                    <span class="font-medium text-sm">It worked</span>
                    <span class="absolute -top-10 left-1/2 -translate-x-1/2 px-3 py-1.5 bg-dark-700 text-gray-200 text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none shadow-lg border border-dark-600">
                      The key redeemed successfully
                    </span>
                  </button>
                  <button
                    type="button"
                    class="group relative flex items-center gap-2 px-5 py-2.5 bg-danger/10 border border-danger/30 rounded-lg text-danger hover:bg-danger/20 hover:border-danger/50 transition-all duration-200"
                    @click="submitFeedback('did_not_work')"
                  >
                    <svg
                      class="w-5 h-5"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"
                      />
                    </svg>
                    <span class="font-medium text-sm">It didn't work</span>
                    <span class="absolute -top-10 left-1/2 -translate-x-1/2 px-3 py-1.5 bg-dark-700 text-gray-200 text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none shadow-lg border border-dark-600">
                      The key was invalid or already used
                    </span>
                  </button>
                </div>
                <div
                  v-else
                  class="flex items-center justify-center gap-2"
                >
                  <div
                    v-if="keyData.feedback === 'worked'"
                    class="flex items-center gap-2 px-4 py-2 bg-success/10 border border-success/30 rounded-lg text-success"
                  >
                    <svg
                      class="w-5 h-5"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"
                      />
                    </svg>
                    <span class="text-sm font-medium">You marked this key as working</span>
                  </div>
                  <div
                    v-else
                    class="flex items-center gap-2 px-4 py-2 bg-danger/10 border border-danger/30 rounded-lg text-danger"
                  >
                    <svg
                      class="w-5 h-5"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"
                      />
                    </svg>
                    <span class="text-sm font-medium">You reported this key as not working</span>
                  </div>
                </div>
              </div>
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
