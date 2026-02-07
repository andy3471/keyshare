<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import groups from '@/routes/groups';

const form = useForm({
  name: '',
  description: '',
  is_public: false,
  avatar: null as File | null,
});

const avatarPreview = ref<string | null>(null);

const initials = computed(() => {
  return form.name ? form.name.charAt(0).toUpperCase() : '?';
});

const handleAvatarChange = (event: Event) => {
  const file = (event.target as HTMLInputElement).files?.[0];
  if (file) {
    form.avatar = file;
    avatarPreview.value = URL.createObjectURL(file);
  }
};

const submit = () => {
  form.post(groups.store.url(), {
    forceFormData: true,
  });
};
</script>

<template>
  <AppLayout title="Create Group">
    <Head title="Create Group" />
    <div class="max-w-2xl mx-auto px-4 py-6">
      <div class="bg-dark-800 rounded-xl p-6 border border-dark-700">
        <h2 class="text-xl font-display font-bold text-white mb-6">
          Create a New Group
        </h2>

        <form
          class="space-y-6"
          @submit.prevent="submit"
        >
          <!-- Avatar -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-3">
              Group Avatar
              <span class="text-gray-500">(optional)</span>
            </label>
            <div class="flex items-center gap-4">
              <div class="relative">
                <div
                  v-if="avatarPreview"
                  class="w-20 h-20 rounded-xl overflow-hidden border-2 border-dark-600"
                >
                  <img
                    :src="avatarPreview"
                    alt="Avatar preview"
                    class="w-full h-full object-cover"
                  >
                </div>
                <div
                  v-else
                  class="w-20 h-20 rounded-xl bg-accent-600/20 border-2 border-dark-600 flex items-center justify-center"
                >
                  <span class="text-accent-400 font-bold text-2xl">{{ initials }}</span>
                </div>
              </div>
              <div>
                <label
                  for="avatar"
                  class="inline-flex items-center px-4 py-2 bg-dark-700 hover:bg-dark-600 text-gray-300 text-sm font-medium rounded-lg transition-colors cursor-pointer"
                >
                  <svg
                    class="w-4 h-4 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                    />
                  </svg>
                  Upload Image
                  <input
                    id="avatar"
                    type="file"
                    accept="image/*"
                    class="hidden"
                    @change="handleAvatarChange"
                  >
                </label>
                <p class="text-xs text-gray-500 mt-1">
                  JPG, PNG or GIF. Max 2MB.
                </p>
              </div>
            </div>
            <p
              v-if="form.errors.avatar"
              class="mt-1 text-sm text-danger-400"
            >
              {{ form.errors.avatar }}
            </p>
          </div>

          <!-- Name -->
          <div>
            <label
              for="name"
              class="block text-sm font-medium text-gray-300 mb-2"
            >
              Group Name
            </label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              class="w-full bg-dark-900 border border-dark-600 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:border-accent-500 focus:ring-1 focus:ring-accent-500 transition-colors"
              placeholder="Enter a group name..."
              required
            >
            <p
              v-if="form.errors.name"
              class="mt-1 text-sm text-danger-400"
            >
              {{ form.errors.name }}
            </p>
          </div>

          <!-- Description -->
          <div>
            <label
              for="description"
              class="block text-sm font-medium text-gray-300 mb-2"
            >
              Description
              <span class="text-gray-500">(optional)</span>
            </label>
            <textarea
              id="description"
              v-model="form.description"
              rows="3"
              class="w-full bg-dark-900 border border-dark-600 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:border-accent-500 focus:ring-1 focus:ring-accent-500 transition-colors resize-none"
              placeholder="What is this group about?"
            />
            <p
              v-if="form.errors.description"
              class="mt-1 text-sm text-danger-400"
            >
              {{ form.errors.description }}
            </p>
          </div>

          <!-- Public toggle -->
          <div class="flex items-center justify-between">
            <div>
              <label
                for="is_public"
                class="text-sm font-medium text-gray-300"
              >
                Public Group
              </label>
              <p class="text-xs text-gray-500 mt-0.5">
                Anyone can find and join a public group
              </p>
            </div>
            <button
              id="is_public"
              type="button"
              class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-accent-500 focus:ring-offset-2 focus:ring-offset-dark-800"
              :class="form.is_public ? 'bg-accent-600' : 'bg-dark-600'"
              role="switch"
              :aria-checked="form.is_public"
              @click="form.is_public = !form.is_public"
            >
              <span
                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                :class="form.is_public ? 'translate-x-5' : 'translate-x-0'"
              />
            </button>
          </div>

          <!-- Submit -->
          <div class="flex justify-end">
            <button
              type="submit"
              :disabled="form.processing"
              class="inline-flex items-center px-6 py-2.5 bg-accent-600 hover:bg-accent-500 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-medium rounded-lg transition-colors"
            >
              <svg
                v-if="form.processing"
                class="animate-spin -ml-1 mr-2 h-4 w-4"
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
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"
                />
              </svg>
              Create Group
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
