<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { login, register } from '@/routes';
import passwordRoutes from '@/routes/password';

interface Props {
  steamLoginEnabled?: boolean;
  canResetPassword?: boolean;
}

withDefaults(defineProps<Props>(), {
  steamLoginEnabled: false,
  canResetPassword: true,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(login.url(), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <AuthLayout>
    <Head title="Login" />

    <h2 class="text-xl font-semibold text-white mb-6">
      Sign in to your account
    </h2>

    <form
      class="space-y-5"
      @submit.prevent="submit"
    >
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
          autofocus
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
        <div class="flex items-center justify-between mb-1.5">
          <label
            for="password"
            class="block text-sm font-medium text-gray-300"
          >
            Password
          </label>
          <Link
            v-if="canResetPassword"
            :href="passwordRoutes.request.url()"
            class="text-xs text-accent-400 hover:text-accent-300 transition-colors"
          >
            Forgot password?
          </Link>
        </div>
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

      <div class="flex items-center gap-2">
        <input
          id="remember"
          v-model="form.remember"
          type="checkbox"
          class="h-4 w-4 rounded border-dark-600 bg-dark-900 text-accent-600 focus:ring-accent-500 focus:ring-offset-0"
        >
        <label
          for="remember"
          class="text-sm text-gray-400"
        >
          Remember me
        </label>
      </div>

      <button
        type="submit"
        class="w-full bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-2.5 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 disabled:opacity-50 disabled:cursor-not-allowed"
        :disabled="form.processing"
      >
        <span v-if="form.processing">Signing in...</span>
        <span v-else>Sign in</span>
      </button>

      <p class="text-center text-sm text-gray-500">
        Don't have an account?
        <Link
          :href="register.url()"
          class="text-accent-400 hover:text-accent-300 font-medium transition-colors"
        >
          Register
        </Link>
      </p>
    </form>
  </AuthLayout>
</template>
