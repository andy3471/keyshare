<script setup lang="ts">
import { ref } from 'vue';
import { useForm, usePage, Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import users from '@/routes/users';
import type { AuthUser, FlashProps } from '@/types/global';

const page = usePage();
const auth = (page.props.auth as AuthUser | undefined) ?? { user: null };
const flash = (page.props.flash as FlashProps | undefined) ?? {};

const imagePreview = ref<string | null>(null);

const form = useForm({
  _method: 'put' as const,
  name: auth.user?.name ?? '',
  email: auth.user?.email ?? '',
  bio: auth.user?.bio ?? '',
  image: null as File | null,
});

const handleImageChange = (event: Event) => {
  const target = event.target as HTMLInputElement;
  const file = target.files?.[0];
  if (file) {
    form.image = file;
    // Create preview
    const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target?.result as string;
    };
    reader.readAsDataURL(file);
  }
};

const submit = () => {
  if (!auth.user?.id) return;

  form.post(users.update.url(auth.user.id), {
    preserveScroll: true,
    forceFormData: true,
  });
};
</script>

<template>
  <AppLayout :title="auth.user?.name || 'Edit Profile'">
    <Head :title="'Edit Profile - ' + (auth.user?.name || '')" />
    <div class="max-w-4xl mx-auto px-4 py-6">
      <!-- Flash Messages -->
      <div
        v-if="flash.message"
        class="mb-6 bg-green-900/50 border border-green-700 rounded-lg p-4 text-green-300"
      >
        {{ flash.message }}
      </div>
      <div
        v-if="flash.error"
        class="mb-6 bg-red-900/50 border border-red-700 rounded-lg p-4 text-red-300"
      >
        {{ flash.error }}
      </div>

      <div class="bg-dark-800 rounded-lg border border-dark-700 p-8">
        <h1 class="text-3xl font-bold text-white mb-6">
          Edit Profile
        </h1>

        <form
          enctype="multipart/form-data"
          class="space-y-6"
          @submit.prevent="submit"
        >
          <!-- Error Display -->
          <div
            v-if="Object.keys(form.errors).length > 0"
            class="bg-red-900/50 border border-red-700 rounded-lg p-4"
          >
            <div
              v-for="(error, field) in form.errors"
              :key="field"
              class="text-red-300 text-sm mb-1"
            >
              <strong class="capitalize">{{ field }}:</strong> {{ Array.isArray(error) ? error[0] : error }}
            </div>
          </div>

          <!-- Profile Image Section -->
          <div class="bg-dark-700/50 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-white mb-4">
              Profile Image
            </h2>
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
              <div class="flex-shrink-0">
                <div class="relative">
                  <img
                    :src="imagePreview || auth.user?.avatar || ''"
                    :alt="auth.user?.name"
                    class="w-32 h-32 rounded-full border-4 border-dark-600 shadow-lg object-cover"
                  >
                  <div class="absolute inset-0 rounded-full bg-black/50 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="text-white text-sm font-medium">Preview</span>
                  </div>
                </div>
              </div>
              <div class="flex-1">
                <label
                  for="image"
                  class="block text-sm font-medium text-gray-300 mb-2"
                >
                  Upload New Image
                </label>
                <input
                  id="image"
                  type="file"
                  accept="image/*"
                  class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 w-full file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-accent-600 file:text-white hover:file:bg-accent-700 file:cursor-pointer"
                  @change="handleImageChange"
                >
                <p class="mt-2 text-xs text-gray-500">
                  Max size: 2MB
                </p>
                <div
                  v-if="form.errors.image"
                  class="mt-2 text-sm text-red-400"
                >
                  {{ form.errors.image }}
                </div>
              </div>
            </div>
          </div>

          <!-- Personal Information Section -->
          <div class="bg-dark-700/50 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-white mb-4">
              Personal Information
            </h2>
            <div class="space-y-4">
              <div>
                <label
                  for="name"
                  class="block text-sm font-medium text-gray-300 mb-2"
                >
                  Name <span class="text-red-400">*</span>
                </label>
                <input
                  id="name"
                  v-model="form.name"
                  name="name"
                  type="text"
                  required
                  class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full"
                  placeholder="Your display name"
                >
                <div
                  v-if="form.errors.name"
                  class="mt-1 text-sm text-red-400"
                >
                  {{ form.errors.name }}
                </div>
              </div>

              <div>
                <label
                  for="email"
                  class="block text-sm font-medium text-gray-300 mb-2"
                >
                  Email
                </label>
                <input
                  id="email"
                  v-model="form.email"
                  name="email"
                  type="email"
                  class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full"
                  placeholder="your.email@example.com"
                  disabled
                >
                <p class="mt-1 text-xs text-gray-500">
                  Email cannot be changed
                </p>
              </div>

              <div>
                <label
                  for="bio"
                  class="block text-sm font-medium text-gray-300 mb-2"
                >
                  Bio
                </label>
                <textarea
                  id="bio"
                  v-model="form.bio"
                  name="bio"
                  rows="4"
                  class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full resize-none"
                  placeholder="Tell us about yourself..."
                />
                <p class="mt-1 text-xs text-gray-500">
                  A short description about yourself
                </p>
                <div
                  v-if="form.errors.bio"
                  class="mt-1 text-sm text-red-400"
                >
                  {{ form.errors.bio }}
                </div>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex flex-col sm:flex-row gap-4 pt-4">
            <button
              type="submit"
              class="flex-1 bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
              :disabled="form.processing"
            >
              <span
                v-if="form.processing"
                class="flex items-center justify-center"
              >
                <svg
                  class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                  />
                  <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                  />
                </svg>
                Saving...
              </span>
              <span
                v-else
                class="flex items-center justify-center"
              >
                <svg
                  class="w-5 h-5 mr-2"
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
                Save Changes
              </span>
            </button>
            <Link
              :href="auth.user?.id ? users.show.url(auth.user?.id) : ''"
              class="flex-1 bg-dark-700 hover:bg-dark-600 text-gray-300 hover:text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 text-center"
            >
              Cancel
            </Link>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
