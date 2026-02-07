<template>
    <AuthLayout>
        <Head title="Demo Mode" />

        <div class="text-center">
            <h1 class="text-2xl font-bold text-white mb-4">Demo Mode</h1>
            <p class="text-gray-300">
                Demo mode information message.
            </p>
        </div>
    </AuthLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
</script>
