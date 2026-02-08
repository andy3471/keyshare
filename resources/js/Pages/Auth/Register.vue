<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import FormInput from '@/Components/ui/FormInput.vue';
import LoadingSpinner from '@/Components/ui/LoadingSpinner.vue';
import SocialLoginButtons from '@/Components/auth/SocialLoginButtons.vue';
import type { SocialProvider } from '@/Components/auth/SocialLoginButtons.vue';
import { register as registerRoute, login } from '@/routes';

interface Props {
  providers: SocialProvider[];
}

defineProps<Props>();

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

  <AuthLayout>
    <h2 class="text-xl font-semibold text-white mb-1">
      Create Account
    </h2>
    <p class="text-gray-400 text-sm mb-6">
      Create your account
    </p>

    <SocialLoginButtons
      v-if="providers.length"
      :providers="providers"
    />

    <div
      v-if="providers.length"
      class="relative my-6"
    >
      <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-dark-600" />
      </div>
      <div class="relative flex justify-center text-sm">
        <span class="bg-dark-800 px-3 text-gray-500">or register with email</span>
      </div>
    </div>

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

    <p class="text-center text-gray-400 text-sm mt-6">
      Already have an account?
      <Link
        :href="login.url()"
        class="text-accent-400 hover:text-accent-300 font-medium"
      >
        Sign in
      </Link>
    </p>
  </AuthLayout>
</template>
