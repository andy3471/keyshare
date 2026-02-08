<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import GameBanner from '@/Components/shared/GameBanner.vue';
import KeyFeedbackSection from '@/Components/keys/KeyFeedbackSection.vue';
import SharedByCard from '@/Components/keys/SharedByCard.vue';
import { KeyData, KeyFeedback } from '@/Types/generated';
import type { FlashProps } from '@/types/global';
import { claim as claimRoute, feedback as feedbackRoute } from '@/routes/keys';
import { useCountdown } from '@/Composables/useCountdown';
import PlatformIcon from '@/Components/shared/PlatformIcon.vue';
import { InformationCircleIcon, ExclamationTriangleIcon, ClockIcon, ClipboardDocumentIcon, CheckIcon } from '@heroicons/vue/24/outline';

interface Props {
  keyData: KeyData;
}

const props = defineProps<Props>();
const keyData = computed(() => props.keyData);
const page = usePage();
const flash = (page.props.flash as FlashProps | undefined) ?? {};
const copied = ref(false);

const form = useForm({ id: keyData.value.id });
watch(() => keyData.value.id, (newId) => { form.id = newId; });

const { isExpired: cooldownExpired, formatted: cooldownFormatted } = useCountdown(keyData.value.can?.cooldownEndsAt ?? null);
watch(cooldownExpired, (expired) => {
  if (expired) {
    router.reload({ only: ['keyData'] });
  }
});

const copyKeyCode = async () => {
  if (!keyData.value.key) return;
  try {
    await navigator.clipboard.writeText(keyData.value.key);
    copied.value = true;
    setTimeout(() => { copied.value = false; }, 2000);
  } catch {
    const input = document.getElementById(`keycode-${keyData.value.id}`) as HTMLInputElement | null;
    if (input != null) {
      input.select();
      document.execCommand('copy');
      copied.value = true;
      setTimeout(() => { copied.value = false; }, 2000);
    }
  }
};

const claimKey = () => {
  if (!keyData.value.id) return;
  form.post(claimRoute.url(keyData.value.id), { preserveScroll: true });
};

const submitFeedback = (value: KeyFeedback) => {
  router.post(feedbackRoute.url(keyData.value.id), { feedback: value }, { preserveScroll: true });
};
</script>

<template>
  <AppLayout
    v-if="keyData"
    :title="keyData.game?.name || 'Key'"
  >
    <Head :title="`${keyData.game?.name || 'Key'} - ${keyData.platform?.name || 'Key'}`" />
    <div class="max-w-7xl mx-auto px-4 py-6">
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

      <div
        v-if="keyData.game"
        class="mb-8"
      >
        <GameBanner
          :game="keyData.game"
          :platform-name="keyData.platform?.name"
          :platform-icon="keyData.platform?.icon"
          linkable
        />
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-dark-800 rounded-lg border border-dark-700 p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-white">
              Key Details
            </h2>
            <div
              v-if="keyData.platform?.name"
              class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary-600/20 border border-primary-600/30 rounded-lg"
            >
              <PlatformIcon
                :icon="keyData.platform.icon"
                size="md"
                class="text-primary-400"
              />
              <span class="text-primary-300 font-semibold">{{ keyData.platform.name }}</span>
            </div>
          </div>

          <form
            class="space-y-4"
            @submit.prevent="claimKey"
          >
            <div v-if="keyData.can?.claim">
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Key Code</label>
                <input
                  class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-3 w-full opacity-60 cursor-not-allowed font-mono text-lg tracking-wider"
                  type="text"
                  value="*****-*****-*****-*****"
                  disabled
                >
              </div>
              <button
                type="submit"
                class="w-full mt-4 bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5 active:translate-y-0"
              >
                Claim Key
              </button>
              <p class="text-gray-400 text-sm text-center mt-4">
                Click to claim this key
              </p>
            </div>

            <div v-else-if="keyData.can?.claimDeniedReason === 'own_key' || keyData.can?.claimDeniedReason === 'karma_too_low' || keyData.can?.claimDeniedReason === 'cooldown_active'">
              <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">Key Code</label>
                <input
                  class="border border-dark-700 rounded-lg bg-dark-900/50 text-gray-600 px-4 py-3 w-full opacity-40 cursor-not-allowed font-mono text-lg tracking-wider"
                  type="text"
                  value="*****-*****-*****-*****"
                  disabled
                >
              </div>

              <div
                v-if="keyData.can?.claimDeniedReason === 'own_key'"
                class="bg-primary-600/10 border border-primary-600/30 rounded-lg p-4 mt-4"
              >
                <div class="flex items-start gap-3">
                  <InformationCircleIcon class="w-5 h-5 text-primary-400 flex-shrink-0 mt-0.5" />
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

              <div
                v-else-if="keyData.can?.claimDeniedReason === 'karma_too_low'"
                class="bg-warning/10 border border-warning/30 rounded-lg p-4 mt-4"
              >
                <div class="flex items-start gap-3">
                  <ExclamationTriangleIcon class="w-5 h-5 text-warning flex-shrink-0 mt-0.5" />
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

              <div
                v-else-if="keyData.can?.claimDeniedReason === 'cooldown_active'"
                class="bg-primary-600/10 border border-primary-600/30 rounded-lg p-4 mt-4"
              >
                <div class="flex items-start gap-3">
                  <ClockIcon class="w-5 h-5 text-primary-400 flex-shrink-0 mt-0.5" />
                  <div>
                    <p class="text-primary-300 font-medium text-sm">
                      Claim cooldown active
                    </p>
                    <p class="text-gray-400 text-sm mt-1">
                      You can claim another key in <span class="text-white font-semibold tabular-nums">{{ cooldownFormatted }}</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div v-else-if="keyData.key">
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Your Key Code</label>
                <div class="relative">
                  <input
                    :id="`keycode-${keyData.id}`"
                    readonly
                    class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-3 pr-12 w-full font-mono text-lg tracking-wider cursor-text select-all"
                    type="text"
                    :value="keyData.key"
                  >
                  <button
                    type="button"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-dark-700 hover:bg-dark-600 text-gray-300 hover:text-white p-2 rounded-lg transition-colors"
                    :title="copied ? 'Copied!' : 'Copy to clipboard'"
                    @click="copyKeyCode"
                  >
                    <CheckIcon
                      v-if="copied"
                      class="w-5 h-5 text-green-400"
                    />
                    <ClipboardDocumentIcon
                      v-else
                      class="w-5 h-5"
                    />
                  </button>
                </div>
              </div>
              <a
                v-if="keyData.platform?.name === 'Steam'"
                :href="`https://store.steampowered.com/account/registerkey?key=${keyData.key}`"
                target="_blank"
                class="block w-full mt-4 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 text-center shadow-lg shadow-primary-600/20 hover:shadow-xl hover:shadow-primary-600/30 hover:-translate-y-0.5"
              >
                Redeem on Steam
              </a>

              <KeyFeedbackSection
                :feedback="keyData.feedback ?? null"
                :can-feedback="!!keyData.can?.feedback"
                @submit="submitFeedback"
              />
            </div>

            <div v-else>
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Key Code</label>
                <input
                  class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-3 w-full opacity-60 cursor-not-allowed font-mono text-lg tracking-wider"
                  type="text"
                  value="*****-*****-*****-*****"
                  disabled
                >
              </div>
              <button
                type="submit"
                class="w-full mt-4 bg-accent-600 text-white font-semibold py-3 px-6 rounded-lg opacity-50 cursor-not-allowed"
                disabled
              >
                Claim Key
              </button>
              <p class="text-gray-400 text-sm text-center mt-4">
                This key has already been claimed
              </p>
            </div>
          </form>
        </div>

        <SharedByCard
          v-if="keyData.createdUser"
          :user="keyData.createdUser"
          :group="keyData.group"
        />
      </div>

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
