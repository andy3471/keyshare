<template>
  <AuthLayout>
    <Head title="Login" />

    <div
      v-if="demoMode"
      class="mb-4 p-4 bg-warning/20 border border-warning rounded text-warning text-sm"
    >
      Demo mode is enabled
    </div>

    <form
      class="space-y-4"
      @submit.prevent="submit"
    >
      <div>
        <label
          for="email"
          class="block text-sm font-medium text-gray-300 mb-2"
        >
          E-Mail Address
        </label>
        <input
          id="email"
          v-model="form.email"
          type="email"
          required
          autofocus
          class="border border-dark-600 rounded-lg bg-dark-800 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full"
          :class="{ 'border-danger': form.errors.email }"
        >
        <div
          v-if="form.errors.email"
          class="mt-1 text-sm text-danger"
        >
          {{ form.errors.email }}
        </div>
      </div>

      <div>
        <label
          for="password"
          class="block text-sm font-medium text-gray-300 mb-2"
        >
          Password
        </label>
        <input
          id="password"
          v-model="form.password"
          type="password"
          required
          class="border border-dark-600 rounded-lg bg-dark-800 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full"
          :class="{ 'border-danger': form.errors.password }"
        >
        <div
          v-if="form.errors.password"
          class="mt-1 text-sm text-danger"
        >
          {{ form.errors.password }}
        </div>
      </div>

      <div class="flex items-center">
        <input
          id="remember"
          v-model="form.remember"
          type="checkbox"
          class="mr-2"
        >
        <label
          for="remember"
          class="text-sm text-gray-300"
        >
          Remember Me
        </label>
      </div>

      <div
        v-if="steamLoginEnabled"
        class="flex justify-center my-4"
      >
        <Link :href="loginLinkedAccount.linkedAccount.steam.url()">
          <img
            :src="'/images/steamlogin.png'"
            alt="Sign in through Steam"
          >
        </Link>
      </div>

      <div class="flex items-center justify-between">
        <button
          type="submit"
          class="bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-2.5 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed"
          :disabled="form.processing"
        >
          <span v-if="form.processing">Logging in...</span>
          <span v-else>Login</span>
        </button>

        <div class="flex space-x-4">
          <Link
            v-if="canResetPassword"
            :href="passwordRoutes.request.url()"
            class="text-sm text-accent-400 hover:text-accent-300"
          >
            Forgot Your Password?
          </Link>
          <Link
            :href="register.url()"
            class="text-sm text-accent-400 hover:text-accent-300"
          >
            Register
          </Link>
        </div>
      </div>
    </form>
  </AuthLayout>
</template>

<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { login, register } from '@/routes';
import passwordRoutes from '@/routes/password';
import loginLinkedAccount from '@/routes/login';

interface Props {
  demoMode?: boolean;
  steamLoginEnabled?: boolean;
  canResetPassword?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  demoMode: false,
  steamLoginEnabled: false,
  canResetPassword: true,
});

const form = useForm({
  email: props.demoMode ? 'admin@admin.com' : '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(login.url(), {
    onFinish: () => form.reset('password'),
  });
};
</script>
