<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { register, login } from '@/routes';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(register.url(), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <AuthLayout>
    <Head title="Register" />

    <h2 class="text-xl font-semibold text-white mb-6">
      Create your account
    </h2>

    <form
      class="space-y-5"
      @submit.prevent="submit"
    >
      <div>
        <label
          for="name"
          class="block text-sm font-medium text-gray-300 mb-1.5"
        >
          Name
        </label>
        <input
          id="name"
          v-model="form.name"
          type="text"
          placeholder="Your name"
          required
          autofocus
          class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-600 w-full"
          :class="{ 'border-danger focus:ring-danger': form.errors.name }"
        >
        <p
          v-if="form.errors.name"
          class="mt-1.5 text-sm text-danger"
        >
          {{ form.errors.name }}
        </p>
      </div>

      <div>
        <label
          for="email"
          class="block text-sm font-medium text-gray-300 mb-1.5"
        >
          Email
        </label>
        <input
          id="email"
          v-model="form.email"
          type="email"
          placeholder="you@example.com"
          required
          class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-600 w-full"
          :class="{ 'border-danger focus:ring-danger': form.errors.email }"
        >
        <p
          v-if="form.errors.email"
          class="mt-1.5 text-sm text-danger"
        >
          {{ form.errors.email }}
        </p>
      </div>

      <div>
        <label
          for="password"
          class="block text-sm font-medium text-gray-300 mb-1.5"
        >
          Password
        </label>
        <input
          id="password"
          v-model="form.password"
          type="password"
          placeholder="••••••••"
          required
          class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-600 w-full"
          :class="{ 'border-danger focus:ring-danger': form.errors.password }"
        >
        <p
          v-if="form.errors.password"
          class="mt-1.5 text-sm text-danger"
        >
          {{ form.errors.password }}
        </p>
      </div>

      <div>
        <label
          for="password_confirmation"
          class="block text-sm font-medium text-gray-300 mb-1.5"
        >
          Confirm password
        </label>
        <input
          id="password_confirmation"
          v-model="form.password_confirmation"
          type="password"
          placeholder="••••••••"
          required
          class="border border-dark-600 rounded-lg bg-dark-900 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-600 w-full"
        >
      </div>

      <button
        type="submit"
        class="w-full bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-2.5 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 disabled:opacity-50 disabled:cursor-not-allowed"
        :disabled="form.processing"
      >
        <span v-if="form.processing">Creating account...</span>
        <span v-else>Create account</span>
      </button>

      <p class="text-center text-sm text-gray-500">
        Already have an account?
        <Link
          :href="login.url()"
          class="text-accent-400 hover:text-accent-300 font-medium transition-colors"
        >
          Sign in
        </Link>
      </p>
    </form>
  </AuthLayout>
</template>
