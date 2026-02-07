<template>
    <AppLayout :title="game.name">
        <Head :title="game.name" />
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="mb-6">
                <img
                    v-if="game.image"
                    :src="game.image"
                    :alt="game.name"
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

            <p v-if="game.description" class="text-gray-300 mb-4">{{ game.description }}</p>

            <div v-if="genres && genres.length > 0" class="mb-4">
                <span
                    v-for="genre in genres"
                    :key="genre.id"
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold shadow-md bg-primary-600 text-white shadow-primary-600/30 mr-2"
                >
                    {{ genre.name }}
                </span>
            </div>

            <div v-if="igdb && igdb.aggregated_rating" class="mb-6 text-gray-300">
                Rated an average of {{ igdb.aggregated_rating }} by
                {{ igdb.aggregated_rating_count }} reviewers
            </div>

            <h2 class="text-2xl font-bold text-white mb-4 mt-8">Available Keys</h2>

            <div v-if="keys.length === 0" class="bg-dark-800 rounded-lg border border-dark-700 p-12 text-center">
                <div class="inline-flex flex-col items-center space-y-4">
                    <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    <div>
                        <p class="text-xl font-medium text-gray-300">No keys available</p>
                        <p class="text-sm text-gray-500 mt-1">Be the first to share a key for this game!</p>
                    </div>
                </div>
            </div>
            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <KeyCard
                    v-for="keyItem in keys"
                    :key="keyItem.id"
                    :key-data="keyItem"
                />
            </div>

            <div v-if="dlcGames && dlcGames.length > 0" class="mt-8">
                <TitleHeader title="DLC" />
                <GameList :games="dlcGames" :pagination="dlcPagination" />
            </div>

            <div v-if="screenshots && screenshots.length > 0" class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                <img
                    v-for="screenshot in screenshots"
                    :key="screenshot.id"
                    :src="`https://images.igdb.com/igdb/image/upload/t_screenshot_big/${screenshot.image_id}.jpg`"
                    alt="Game Screenshot"
                    class="rounded-lg border border-dark-700 w-full h-auto"
                />
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleHeader from '@/Components/TitleHeader.vue';
import GameList from '@/Components/GameList.vue';
import KeyCard from '@/Components/KeyCard.vue';
import { GameShowData } from '@/Types/generated';

interface Props {
    game: GameShowData['game'];
    keys: GameShowData['keys'];
    dlcGames?: Array<{ id: number; name: string; image?: string; url: string }>;
    dlcPagination?: {
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    igdb?: {
        aggregated_rating?: number;
        aggregated_rating_count?: number;
    };
    genres?: Array<{ id: number; name: string }>;
    screenshots?: Array<{ id: number; image_id: string }>;
}

defineProps<Props>();
</script>
