<template>
  <div class="bg-dark-800 rounded-lg border border-dark-700 p-8">
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-white mb-2">
        Add New Key
      </h1>
      <p class="text-gray-400">
        Share a game key with the community
      </p>
    </div>

    <form
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
          <strong class="capitalize">{{ field.replace('_', ' ') }}:</strong> {{ Array.isArray(error) ? error[0] : error }}
        </div>
      </div>

      <!-- Game Selection Section -->
      <div class="bg-dark-700/50 rounded-lg p-6">
        <h2 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
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
              d="M14.752 11.168l-3.197-2.132A1 1 0 0011 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
            />
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          Game Information
        </h2>
        <div class="space-y-4">
          <div>
            <label
              for="igdb_id"
              class="block text-sm font-medium text-gray-300 mb-2"
            >
              Game or DLC <span class="text-red-400">*</span>
            </label>
            <Autocomplete
              id="igdb_id"
              v-model="form.igdb_id"
              name="igdb_id"
              placeholder="Search for a game or DLC..."
              url="/autocomplete"
              input-class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full"
              @select="handleGameSelect"
            />
            <p class="mt-2 text-xs text-gray-500">
              Start typing to search IGDB for games and DLCs
            </p>
            <div
              v-if="form.errors.igdb_id"
              class="mt-2 text-sm text-red-400"
            >
              {{ form.errors.igdb_id }}
            </div>
          </div>

          <div>
            <label
              for="platform"
              class="block text-sm font-medium text-gray-300 mb-2"
            >
              Platform <span class="text-red-400">*</span>
            </label>
            <select
              id="platform"
              v-model="form.platform_id"
              name="platform_id"
              class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 w-full cursor-pointer"
            >
              <option
                value=""
                disabled
              >
                Select a platform
              </option>
              <option
                v-for="platform in platforms"
                :key="platform.id"
                :value="platform.id"
              >
                {{ platform.name }}
              </option>
            </select>
            <div
              v-if="form.errors.platform_id"
              class="mt-2 text-sm text-red-400"
            >
              {{ form.errors.platform_id }}
            </div>
          </div>
        </div>
      </div>

      <!-- Key Details Section -->
      <div class="bg-dark-700/50 rounded-lg p-6">
        <h2 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
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
              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"
            />
          </svg>
          Key Details
        </h2>
        <div class="space-y-4">
          <div>
            <label
              for="key"
              class="block text-sm font-medium text-gray-300 mb-2"
            >
              Key Code <span class="text-red-400">*</span>
            </label>
            <input
              id="key"
              v-model="form.key"
              name="key"
              type="text"
              required
              placeholder="XXXXX-XXXXX-XXXXX-XXXXX"
              class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full font-mono text-lg tracking-wider"
            >
            <p class="mt-2 text-xs text-gray-500">
              Enter the game key code
            </p>
            <div
              v-if="form.errors.key"
              class="mt-2 text-sm text-red-400"
            >
              {{ form.errors.key }}
            </div>
          </div>

          <div>
            <label
              for="message"
              class="block text-sm font-medium text-gray-300 mb-2"
            >
              Message (Optional)
            </label>
            <textarea
              id="message"
              v-model="form.message"
              name="message"
              rows="4"
              placeholder="Add a message for the person who claims this key..."
              class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full resize-none"
            />
            <p class="mt-2 text-xs text-gray-500">
              Optional message to include with your shared key
            </p>
            <div
              v-if="form.errors.message"
              class="mt-2 text-sm text-red-400"
            >
              {{ form.errors.message }}
            </div>
          </div>
        </div>
      </div>

      <!-- Submit Button -->
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
            Adding Key...
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
                d="M12 4v16m8-8H4"
              />
            </svg>
            Add Key
          </span>
        </button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import Autocomplete from './Autocomplete.vue';
import { PlatformData } from '@/Types/generated';
import type { AutocompleteItem } from '@/types/global';
import keys from '@/routes/keys';

interface Props {
  platforms: PlatformData[];
}

defineProps<Props>();

const form = useForm({
  igdb_id: '',
  platform_id: '',
  key: '',
  message: '',
});

const handleGameSelect = (item: AutocompleteItem) => {
  form.igdb_id = item.id;
};

const submit = () => {
  if (!form.platform_id) {
    form.setError('platform_id', 'Please select a platform.');
    return;
  }

  form.post(keys.store.url(), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>
