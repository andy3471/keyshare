<template>
    <Link
        :href="keyRoutes.show(keyData.id)"
        class="group relative bg-dark-800 rounded-lg border border-dark-700 p-4 transition-all duration-300 hover:border-accent-500 hover:shadow-xl hover:shadow-accent-500/20 hover:-translate-y-1"
    >
        <div class="flex items-center justify-between mb-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-accent-600/20 text-accent-400 border border-accent-600/30">
                {{ keyData.platform?.name || 'Unknown Platform' }}
            </span>
            <div
                v-if="keyData.can.claim"
                class="flex items-center space-x-1 text-success text-xs font-medium"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Available</span>
            </div>
            <div
                v-else
                class="flex items-center space-x-1 text-gray-500 text-xs font-medium"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>Claimed</span>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <div class="relative flex-shrink-0">
                <img
                    :src="keyData.createdUser?.avatar"
                    :alt="keyData.createdUser?.name || 'Unknown User'"
                    class="w-12 h-12 rounded-full border-2 border-dark-600 group-hover:border-accent-500 transition-colors"
                />
                <div class="absolute -bottom-1 -right-1">
                    <span
                        :class="[
                            'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold shadow-md',
                            keyData.createdUser?.karma_colour === 'badge-danger' ? 'bg-danger text-white shadow-danger/30' :
                            keyData.createdUser?.karma_colour === 'badge-warning' ? 'bg-warning text-white shadow-warning/30' :
                            keyData.createdUser?.karma_colour === 'badge-info' ? 'bg-primary-600 text-white shadow-primary-600/30' :
                            'bg-success text-white shadow-success/30'
                        ]"
                    >
                        {{ keyData.createdUser?.karma || 0 }}
                    </span>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white font-medium truncate group-hover:text-accent-400 transition-colors">
                    {{ keyData.createdUser?.name || 'Unknown User' }}
                </p>
                <p v-if="keyData.message" class="text-gray-400 text-sm truncate mt-1">
                    {{ keyData.message }}
                </p>
            </div>
        </div>

        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </div>
    </Link>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { KeyData } from '@/Types/generated';
import keyRoutes from '@/routes/keys';

interface Props {
    keyData: KeyData;
}

const props = defineProps<Props>();
</script>
