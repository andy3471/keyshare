<template>
    <div v-if="flash.message || flash.error" class="max-w-7xl mx-auto px-4 mt-4">
        <div
            v-if="flash.message"
            class="bg-success text-white px-4 py-3 rounded relative"
            role="alert"
        >
            <span class="block sm:inline">{{ flash.message }}</span>
            <button
                @click="dismissMessage"
                class="absolute top-0 bottom-0 right-0 px-4 py-3"
            >
                <span class="sr-only">Dismiss</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div
            v-if="flash.error"
            class="bg-danger text-white px-4 py-3 rounded relative"
            role="alert"
        >
            <span class="block sm:inline">{{ flash.error }}</span>
            <button
                @click="dismissError"
                class="absolute top-0 bottom-0 right-0 px-4 py-3"
            >
                <span class="sr-only">Dismiss</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const flash = (page.props.flash as { message?: string; error?: string }) || {};

const dismissMessage = () => {
    // Flash messages are server-side, so we can't really dismiss them client-side
    // This is just for UI feedback
};

const dismissError = () => {
    // Flash messages are server-side, so we can't really dismiss them client-side
    // This is just for UI feedback
};
</script>
