<template>
    <!-- Key Availability Badge - Top Right Corner -->
    <div
        v-if="hasKey"
        class="absolute top-2 right-2 z-10 bg-green-500/95 backdrop-blur-sm rounded-full p-2 shadow-lg shadow-green-500/50"
        :title="`${keyCount} ${keyCount === 1 ? 'key' : 'keys'} available`"
    >
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
        </svg>
        <span class="absolute -top-1 -right-1 bg-white text-green-600 text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
            {{ keyCount }}
        </span>
    </div>
    <div
        v-else
        class="absolute top-2 right-2 z-10 bg-gray-600/80 backdrop-blur-sm rounded-full p-2"
        title="No keys available"
    >
        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
        </svg>
    </div>
</template>

<script setup lang="ts">
interface Props {
    hasKey: boolean;
    keyCount: number;
}

defineProps<Props>();
</script>
