<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Props {
  status: number;
}

const props = defineProps<Props>();

const title = computed(() => {
  return (
    {
      503: 'Service Unavailable',
      500: 'Server Error',
      404: 'Page Not Found',
      403: 'Forbidden',
    }[props.status] ?? 'Error'
  );
});

const description = computed(() => {
  return (
    {
      503: 'We\'re doing some maintenance. Please check back soon.',
      500: 'Something went wrong on our end. Please try again later.',
      404: 'The page you\'re looking for doesn\'t exist or has been moved.',
      403: 'You don\'t have permission to access this page.',
    }[props.status] ?? 'An unexpected error occurred.'
  );
});

const icon = computed(() => {
  if (props.status === 404) {
    return 'search';
  }
  if (props.status === 403) {
    return 'lock';
  }
  return 'alert';
});
</script>

<template>
  <Head :title="`${status} - ${title}`" />

  <div class="min-h-screen flex flex-col bg-dark-950">
    <div class="flex-1 flex flex-col items-center justify-center px-4">
      <div class="text-center max-w-md">
        <!-- Icon -->
        <div class="mb-6">
          <!-- Search icon for 404 -->
          <svg
            v-if="icon === 'search'"
            class="w-16 h-16 mx-auto text-gray-600"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="1.5"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
            />
          </svg>
          <!-- Lock icon for 403 -->
          <svg
            v-else-if="icon === 'lock'"
            class="w-16 h-16 mx-auto text-gray-600"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="1.5"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
            />
          </svg>
          <!-- Alert icon for 500/503 -->
          <svg
            v-else
            class="w-16 h-16 mx-auto text-gray-600"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="1.5"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"
            />
          </svg>
        </div>

        <!-- Status code -->
        <p class="text-6xl font-display font-bold text-gray-700 mb-2">
          {{ status }}
        </p>

        <!-- Title -->
        <h1 class="text-2xl font-semibold text-white mb-3">
          {{ title }}
        </h1>

        <!-- Description -->
        <p class="text-gray-400 mb-8">
          {{ description }}
        </p>

        <!-- Actions -->
        <div class="flex items-center justify-center gap-3">
          <Link
            href="/games"
            class="inline-flex items-center px-5 py-2.5 bg-accent-600 hover:bg-accent-700 text-white font-medium rounded-lg transition-colors text-sm"
          >
            Go Home
          </Link>
          <button
            class="inline-flex items-center px-5 py-2.5 bg-dark-800 hover:bg-dark-700 text-gray-300 font-medium rounded-lg border border-dark-600 transition-colors text-sm"
            @click="$router?.back() ?? history.back()"
          >
            Go Back
          </button>
        </div>
      </div>
    </div>

    <!-- Footer branding -->
    <div class="text-center pb-8">
      <p class="text-sm text-gray-600">
        Sparekey.club
      </p>
    </div>
  </div>
</template>
