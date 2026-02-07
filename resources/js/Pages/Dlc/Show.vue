<template>
    <AppLayout :title="dlc.name">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="mb-6">
                <img
                    v-if="dlc.image"
                    :src="dlc.image"
                    :alt="dlc.name"
                    class="mx-auto rounded-lg max-w-full h-auto"
                />
                <div
                    v-else
                    class="mx-auto rounded-lg max-w-full h-auto min-h-[400px] flex items-center justify-center bg-gradient-to-br from-dark-800 via-dark-700 to-dark-800 border-2 border-accent-600/30 game-image-placeholder"
                >
                    <svg class="w-24 h-24 text-accent-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0011 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <p v-if="dlc.description" class="text-gray-300 mb-4">{{ dlc.description }}</p>

            <div class="bg-dark-800 rounded-lg border border-dark-700 overflow-hidden">
                <table class="min-w-full divide-y divide-dark-700">
                    <thead class="bg-dark-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Platform
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Added By
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-dark-800 divide-y divide-dark-700">
                        <tr v-if="keys.length === 0">
                            <td colspan="2" class="px-6 py-4 text-center text-gray-400">
                                No keys available
                            </td>
                        </tr>
                        <tr
                            v-for="key in keys"
                            :key="key.id"
                            class="hover:bg-dark-700 transition-colors"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <Link
                                    :href="key.url"
                                    class="text-accent-400 hover:text-accent-300"
                                >
                                    {{ key.platform?.name }}
                                </Link>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <Link
                                    :href="`/users/${key.createdUser?.id}`"
                                    class="text-accent-400 hover:text-accent-300"
                                >
                                    {{ key.createdUser?.name }}
                                </Link>
                                <span
                                    :class="[
                                        'badge ml-2',
                                        key.createdUser?.karma_colour === 'badge-danger' ? 'badge-danger' :
                                        key.createdUser?.karma_colour === 'badge-warning' ? 'badge-warning' :
                                        key.createdUser?.karma_colour === 'badge-info' ? 'badge-info' :
                                        'badge-success'
                                    ]"
                                >
                                    {{ key.createdUser?.karma }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { DlcData, KeyData } from '@/Types/generated';

interface Props {
    dlc: DlcData;
    keys: KeyData[];
}

defineProps<Props>();
</script>
