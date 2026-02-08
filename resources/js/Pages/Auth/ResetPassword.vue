<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import FormInput from '@/Components/ui/FormInput.vue';
import LoadingSpinner from '@/Components/ui/LoadingSpinner.vue';
import { login as loginRoute } from '@/routes';
import password from '@/routes/password';

interface Props {
  token: string;
  email: string;
}

const props = defineProps<Props>();

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(password.update.url(), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <Head title="Reset Password" />

  <AuthLayout>
    <h2 class="text-xl font-semibold text-white mb-1">
      Reset Password
    </h2>
    <p class="text-gray-400 text-sm mb-6">
      Enter your new password below.
    </p>

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
        autocomplete="email"
        required
        disabled
      />

      <FormInput
        id="password"
        v-model="form.password"
        label="New Password"
        type="password"
        :error="form.errors.password"
        placeholder="Enter your new password"
        autocomplete="new-password"
        required
      />

      <FormInput
        id="password_confirmation"
        v-model="form.password_confirmation"
        label="Confirm Password"
        type="password"
        :error="form.errors.password_confirmation"
        placeholder="Confirm your new password"
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
          Resetting...
        </span>
        <span v-else>Reset Password</span>
      </button>
    </form>

    <p class="text-center text-gray-400 text-sm mt-6">
      Remember your password?
      <Link
        :href="loginRoute.url()"
        class="text-accent-400 hover:text-accent-300 font-medium"
      >
        Sign in
      </Link>
    </p>
  </AuthLayout>
</template>
