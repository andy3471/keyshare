<template>
  <AuthLayout>
    <Head title="Account Not Approved" />

    <div class="text-center">
      <h1 class="text-2xl font-bold text-white mb-4">
        Account Not Approved
      </h1>
      <p class="text-gray-300">
        Your account is pending approval. Please wait for an administrator to approve your account.
      </p>
    </div>
  </AuthLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
</script>
