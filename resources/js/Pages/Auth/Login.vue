<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import FormInput from '@/Components/ui/FormInput.vue';
import LoadingSpinner from '@/Components/ui/LoadingSpinner.vue';
import { login as loginRoute, register } from '@/routes';
import AppFooter from '@/Components/layout/AppFooter.vue';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(loginRoute.url(), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <Head title="Sign In" />

  <div class="min-h-screen flex flex-col items-center justify-center bg-dark-950 px-4">
    <div class="w-full max-w-md">
      <div class="text-center mb-8">
        <Link
          href="/"
          class="text-3xl font-display font-bold"
        >
          <span class="bg-gradient-to-r from-accent-400 to-primary-400 bg-clip-text text-transparent">Sparekey.club</span>
        </Link>
        <p class="text-gray-400 mt-2">
          Sign in to your account
        </p>
      </div>

      <div class="bg-dark-800 rounded-xl p-8 border border-dark-700 shadow-xl">
        <form
          class="space-y-5"
          @submit.prevent="submit"
        >
          <FormInput
            id="email"
            v-model="form.email"
            label="Email"
            type="email"
            :error="form.errors.email"
            placeholder="you@example.com"
            autocomplete="email"
            required
          />

          <FormInput
            id="password"
            v-model="form.password"
            label="Password"
            type="password"
            :error="form.errors.password"
            placeholder="Enter your password"
            autocomplete="current-password"
            required
          />

          <div class="flex items-center justify-between">
            <label class="flex items-center cursor-pointer">
              <input
                v-model="form.remember"
                type="checkbox"
                class="w-4 h-4 rounded bg-dark-700 border-dark-600 text-accent-600 focus:ring-accent-500"
              >
              <span class="ml-2 text-sm text-gray-400">Remember me</span>
            </label>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-3 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span
              v-if="form.processing"
              class="flex items-center justify-center"
            >
              <LoadingSpinner
                size="sm"
                class="-ml-1 mr-2"
              />
              Signing in...
            </span>
            <span v-else>Sign In</span>
          </button>
        </form>
      </div>

      <p class="text-center text-gray-400 text-sm mt-6">
        Don't have an account?
        <Link
          :href="register.url()"
          class="text-accent-400 hover:text-accent-300 font-medium"
        >
          Create one
        </Link>
      </p>
    </div>

    <div class="mt-auto w-full">
      <AppFooter />
    </div>
  </div>
</template>
