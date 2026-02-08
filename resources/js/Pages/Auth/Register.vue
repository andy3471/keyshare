<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import FormInput from '@/Components/ui/FormInput.vue';
import LoadingSpinner from '@/Components/ui/LoadingSpinner.vue';
import { register as registerRoute, login } from '@/routes';
import AppFooter from '@/Components/layout/AppFooter.vue';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(registerRoute.url(), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <Head title="Create Account" />

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
          Create your account
        </p>
      </div>

      <div class="bg-dark-800 rounded-xl p-8 border border-dark-700 shadow-xl">
        <form
          class="space-y-5"
          @submit.prevent="submit"
        >
          <FormInput
            id="name"
            v-model="form.name"
            label="Name"
            :error="form.errors.name"
            placeholder="Your display name"
            autocomplete="name"
            required
          />

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
            placeholder="Create a strong password"
            autocomplete="new-password"
            required
          />

          <FormInput
            id="password_confirmation"
            v-model="form.password_confirmation"
            label="Confirm Password"
            type="password"
            :error="form.errors.password_confirmation"
            placeholder="Confirm your password"
            autocomplete="new-password"
            required
          />

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
              Creating Account...
            </span>
            <span v-else>Create Account</span>
          </button>
        </form>
      </div>

      <p class="text-center text-gray-400 text-sm mt-6">
        Already have an account?
        <Link
          :href="login.url()"
          class="text-accent-400 hover:text-accent-300 font-medium"
        >
          Sign in
        </Link>
      </p>
    </div>

    <div class="mt-auto w-full">
      <AppFooter />
    </div>
  </div>
</template>
