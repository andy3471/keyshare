<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import FormInput from '@/Components/ui/FormInput.vue';
import LoadingSpinner from '@/Components/ui/LoadingSpinner.vue';
import type { FlashProps } from '@/types/global';
import { login as loginRoute } from '@/routes';
import password from '@/routes/password';

const page = usePage();
const flash = computed(() => (page.props.flash as FlashProps | undefined) ?? {});

const form = useForm({
  email: '',
});

const submit = () => {
  form.post(password.email.url());
};
</script>

<template>
  <Head title="Forgot Password" />

  <AuthLayout>
    <h2 class="text-xl font-semibold text-white mb-1">
      Forgot Password
    </h2>
    <p class="text-gray-400 text-sm mb-6">
      Enter your email and we'll send you a link to reset your password.
    </p>

    <div
      v-if="flash?.status"
      class="mb-4 p-3 rounded-lg bg-green-900/50 border border-green-700 text-green-300 text-sm"
    >
      {{ flash.status }}
    </div>

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
          Sending...
        </span>
        <span v-else>Send Reset Link</span>
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
