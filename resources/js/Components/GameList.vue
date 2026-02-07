<template>
    <InfiniteScroll v-if="games && games.data" data="games" preserve-url>
        <div class="game-grid mt-6">
            <div
                v-for="game in games.data"
                :key="game.id"
                class="game-card"
            >
                <Link :href="game.url">
                    <img
                        v-if="game.image"
                        :src="game.image"
                        :alt="game.name"
                        class="game-image"
                    >
                    <div
                        v-else
                        class="game-image game-image-placeholder flex items-center justify-center bg-gradient-to-br from-dark-800 via-dark-700 to-dark-800 border-2 border-accent-600/30"
                    >
                        <svg class="w-16 h-16 text-accent-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0011 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="game-overlay">{{ game.name }}</div>
                </Link>
            </div>
        </div>
        <div v-if="games.data.length === 0" class="col-span-full text-center text-gray-400 py-4">
            No Games Found
        </div>
    </InfiniteScroll>
    <div v-else class="col-span-full text-center text-gray-400 py-4">
        Loading...
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { InfiniteScroll } from '@inertiajs/vue3';

interface Game {
    id: number;
    name: string;
    image?: string;
    url: string;
}

interface GamesData {
    data: Game[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

interface Props {
    games?: GamesData;
}

const props = withDefaults(defineProps<Props>(), {
    games: () => ({
        data: [],
        current_page: 1,
        last_page: 1,
        per_page: 12,
        total: 0,
    }),
});
</script>
