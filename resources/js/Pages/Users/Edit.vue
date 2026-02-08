<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import FormInput from '@/Components/ui/FormInput.vue';
import FormTextarea from '@/Components/ui/FormTextarea.vue';
import AvatarUpload from '@/Components/shared/AvatarUpload.vue';
import LoadingSpinner from '@/Components/ui/LoadingSpinner.vue';
import { UserData } from '@/Types/generated';
import type { LinkedAccountProvider } from '@/Types/generated';
import users from '@/routes/users';

interface ProviderInfo {
  name: LinkedAccountProvider;
  label: string;
  color: string;
  url: string;
  linked: boolean;
  providerUserId: string | null;
}

interface Props {
  user: UserData;
  providers: ProviderInfo[];
}

const props = defineProps<Props>();

const form = useForm({
  _method: 'PUT',
  name: props.user.name,
  email: props.user.email,
  bio: props.user.bio ?? '',
  avatar: null as File | null,
  password: '',
  password_confirmation: '',
});

const initials = computed(() => form.name ? form.name.charAt(0).toUpperCase() : '?');

const handleAvatarChange = (file: File) => {
  form.avatar = file;
};

const submit = () => {
  form.post(users.update.url(props.user.id), { forceFormData: true });
};

const unlinkAccount = (providerName: string) => {
  router.delete(`/linked-accounts/${providerName}`, {
    preserveScroll: true,
  });
};
</script>

<template>
  <AppLayout title="Edit Profile">
    <Head title="Edit Profile" />
    <div class="max-w-2xl mx-auto px-4 py-6 space-y-6">
      <div class="bg-dark-800 rounded-xl p-6 border border-dark-700">
        <h2 class="text-xl font-display font-bold text-white mb-6">
          Edit Profile
        </h2>

        <form
          class="space-y-6"
          @submit.prevent="submit"
        >
          <AvatarUpload
            :current-image="user.avatar"
            :initials="initials"
            shape="round"
            :error="form.errors.avatar"
            label="Profile Picture"
            @update:file="handleAvatarChange"
          />

          <FormInput
            id="name"
            v-model="form.name"
            label="Name"
            :error="form.errors.name"
            required
          />

          <FormInput
            id="email"
            v-model="form.email"
            label="Email"
            type="email"
            :error="form.errors.email"
            required
          />

          <FormTextarea
            id="bio"
            v-model="form.bio"
            label="Bio"
            placeholder="Tell people a bit about yourself..."
            :error="form.errors.bio"
          >
            <template #label-suffix>
              <span class="text-gray-500"> (optional)</span>
            </template>
          </FormTextarea>

          <div class="border-t border-dark-700 pt-6">
            <h3 class="text-sm font-semibold text-white mb-4">
              Change Password
            </h3>
            <div class="space-y-4">
              <FormInput
                id="password"
                v-model="form.password"
                label="New Password"
                type="password"
                :error="form.errors.password"
                hint="Leave blank to keep your current password"
                autocomplete="new-password"
              />
              <FormInput
                id="password_confirmation"
                v-model="form.password_confirmation"
                label="Confirm New Password"
                type="password"
                :error="form.errors.password_confirmation"
                autocomplete="new-password"
              />
            </div>
          </div>

          <div class="flex justify-end">
            <button
              type="submit"
              :disabled="form.processing"
              class="inline-flex items-center px-6 py-2.5 bg-accent-600 hover:bg-accent-500 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-medium rounded-lg transition-colors"
            >
              <LoadingSpinner
                v-if="form.processing"
                size="sm"
                class="-ml-1 mr-2"
              />
              Save Changes
            </button>
          </div>
        </form>
      </div>

      <!-- Linked Accounts Section -->
      <div
        v-if="providers.length"
        class="bg-dark-800 rounded-xl p-6 border border-dark-700"
      >
        <h2 class="text-xl font-display font-bold text-white mb-2">
          Linked Accounts
        </h2>
        <p class="text-gray-400 text-sm mb-6">
          Connect your gaming accounts for quick sign-in.
        </p>

        <div class="space-y-3">
          <div
            v-for="provider in providers"
            :key="provider.name"
            class="flex items-center justify-between p-4 rounded-lg border border-dark-600 bg-dark-700/50"
          >
            <div class="flex items-center gap-3">
              <div
                class="w-9 h-9 rounded-lg flex items-center justify-center"
                :style="{ backgroundColor: provider.color }"
              >
                <!-- Steam -->
                <svg
                  v-if="provider.name === 'steam'"
                  class="w-5 h-5 text-white"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                >
                  <path d="M11.979 0C5.678 0 .511 4.86.022 11.037l6.432 2.658c.545-.371 1.203-.59 1.912-.59.063 0 .125.004.188.006l2.861-4.142V8.91c0-2.495 2.028-4.524 4.524-4.524 2.494 0 4.524 2.031 4.524 4.527s-2.03 4.525-4.524 4.525h-.105l-4.076 2.911c0 .052.004.105.004.159 0 1.875-1.515 3.396-3.39 3.396-1.635 0-3.016-1.173-3.331-2.727L.436 15.27C1.862 20.307 6.486 24 11.979 24c6.627 0 12-5.373 12-12s-5.373-12-12-12zM7.54 18.21l-1.473-.61c.262.543.714.999 1.314 1.25 1.297.539 2.793-.076 3.332-1.375.263-.63.264-1.319.005-1.949s-.75-1.121-1.377-1.383c-.624-.26-1.29-.249-1.878-.03l1.523.63c.956.4 1.409 1.5 1.009 2.455-.397.957-1.497 1.41-2.454 1.012H7.54zm11.415-9.303c0-1.662-1.353-3.015-3.015-3.015-1.665 0-3.015 1.353-3.015 3.015 0 1.665 1.35 3.015 3.015 3.015 1.663 0 3.015-1.35 3.015-3.015zm-5.273-.005c0-1.252 1.013-2.266 2.265-2.266 1.249 0 2.266 1.014 2.266 2.266 0 1.251-1.017 2.265-2.266 2.265-1.253 0-2.265-1.014-2.265-2.265z" />
                </svg>

                <!-- Twitch -->
                <svg
                  v-if="provider.name === 'twitch'"
                  class="w-5 h-5 text-white"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                >
                  <path d="M11.571 4.714h1.715v5.143H11.57zm4.715 0H18v5.143h-1.714zM6 0L1.714 4.286v15.428h5.143V24l4.286-4.286h3.428L22.286 12V0zm14.571 11.143l-3.428 3.428h-3.429l-3 3v-3H6.857V1.714h13.714z" />
                </svg>

                <!-- Discord -->
                <svg
                  v-if="provider.name === 'discord'"
                  class="w-5 h-5 text-white"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                >
                  <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028 14.09 14.09 0 0 0 1.226-1.994.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z" />
                </svg>

                <!-- Xbox -->
                <svg
                  v-if="provider.name === 'xbox'"
                  class="w-5 h-5 text-white"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                >
                  <path d="M4.102 21.033C6.211 22.881 8.977 24 12 24c3.026 0 5.789-1.119 7.902-2.967 1.877-1.912-4.316-8.709-7.902-11.417-3.582 2.708-9.779 9.505-7.898 11.417zm11.16-14.406c2.5 2.961 7.484 10.313 6.076 12.912C23.002 17.48 24 14.861 24 12.004c0-3.34-1.365-6.362-3.57-8.536 0 0-.027-.022-.082-.042-.063-.025-.152-.078-.32.024-.532.334-3.137 2.18-4.766 3.177zM12 3.604s-2.371-1.861-4.348-2.65C7.451.869 7.253.857 7.137.924 5.289 1.98 3.66 3.396 2.397 5.09a.27.27 0 0 0-.04.098c-.012.063-.024.18.093.334 1.5 1.97 5.044 5.32 6.212 6.658-1.6-4.029 1.044-6.61 3.338-8.576zM12.002 0c-1.574 0-3.076.307-4.449.86-.127.046-.14.18-.023.291.395.373 2.379 2.125 4.472 3.803 2.089-1.678 4.084-3.43 4.473-3.803.12-.11.104-.245-.023-.291A11.924 11.924 0 0 0 12.002 0z" />
                </svg>
              </div>

              <div>
                <p class="text-sm font-medium text-white">
                  {{ provider.label }}
                </p>
                <p
                  v-if="provider.linked"
                  class="text-xs text-gray-400"
                >
                  Connected
                </p>
                <p
                  v-else
                  class="text-xs text-gray-500"
                >
                  Not connected
                </p>
              </div>
            </div>

            <a
              v-if="!provider.linked"
              :href="provider.url"
              class="inline-flex items-center px-4 py-1.5 text-sm font-medium rounded-lg text-white transition-all duration-200 hover:opacity-90"
              :style="{ backgroundColor: provider.color }"
            >
              Connect
            </a>
            <button
              v-else
              class="inline-flex items-center px-4 py-1.5 text-sm font-medium rounded-lg border border-dark-500 text-gray-400 hover:text-white hover:border-danger/50 hover:bg-danger/10 transition-all duration-200"
              @click="unlinkAccount(provider.name)"
            >
              Disconnect
            </button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
