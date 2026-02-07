<template>
    <InfiniteScroll v-if="games && games.data" :data="props.scrollProp" preserve-url>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 mx-auto mt-6">
            <div
                v-for="game in games.data"
                :key="game.id"
                class="game-card group relative"
                :class="{ 'has-keys': game.hasKey }"
            >
                <Link :href="gamesRoute.show.url(game.id)">
                    <KeyAvailabilityBadge
                        v-if="game.hasKey !== undefined"
                        :key-count="game.keyCount || 0"
                    />
                    <img
                        v-if="game.image"
                        :src="game.image"
                        :alt="game.name"
                        class="game-image"
                    >
                    <div
                        v-else
                        class="game-image-placeholder flex items-center justify-center"
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
        <div v-if="games.data.length === 0" class="col-span-full text-center py-12">
            <div class="inline-flex flex-col items-center space-y-4">
                <svg class="w-24 h-24 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xl font-medium text-gray-400">No Games Found</p>
                <p class="text-sm text-gray-500">Try adjusting your search or filters</p>
            </div>
        </div>
    </InfiniteScroll>
    <div v-else class="col-span-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 mx-auto">
            <div v-for="i in 12" :key="i" class="relative w-full max-w-[264px] bg-dark-700 rounded-lg animate-pulse" style="aspect-ratio: 3/4;"></div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { InfiniteScroll } from '@inertiajs/vue3';
import KeyAvailabilityBadge from './KeyAvailabilityBadge.vue';
import gamesRoute from '@/routes/games';

interface Game {
    id: string;
    igdb_id?: string;
    name: string;
    image?: string;
    url?: string;
    hasKey?: boolean;
    keyCount?: number;
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
    scrollProp?: string;
}

const props = withDefaults(defineProps<Props>(), {
    games: () => ({
        data: [],
        current_page: 1,
        last_page: 1,
        per_page: 12,
        total: 0,
    }),
    scrollProp: 'games',
});
</script>

<style scoped>
.game-card {
    @apply relative w-full max-w-[264px] bg-dark-800 rounded-lg border border-dark-700 flex justify-center items-center transition-all duration-300 overflow-hidden;
    @apply hover:border-accent-500 hover:shadow-xl hover:shadow-accent-500/30 hover:-translate-y-1;
    aspect-ratio: 3 / 4;
}

.game-card.has-keys {
    @apply border-green-500/50;
}

.game-card.has-keys:hover {
    @apply border-green-500 shadow-green-500/30;
}

.game-card:hover .game-overlay {
    @apply opacity-100 translate-y-0;
    min-height: 50%;
}

.game-card:hover .game-image {
    @apply scale-110;
}

.game-image {
    @apply block w-full h-full object-cover rounded-lg transition-transform duration-500;
}

.game-image-placeholder {
    @apply min-h-full relative w-full bg-gradient-to-br from-dark-800 via-dark-700 to-dark-800 border-2 border-accent-600/30;
    background-image:
        radial-gradient(circle at 20% 50%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(236, 72, 153, 0.15) 0%, transparent 50%),
        linear-gradient(135deg, rgba(30, 41, 59, 0.9) 0%, rgba(15, 23, 42, 0.95) 100%);
}

.game-image-placeholder::before {
    content: '';
    @apply absolute inset-0 opacity-30;
    background-image:
        repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(139, 92, 246, 0.08) 10px, rgba(139, 92, 246, 0.08) 20px);
}

.game-overlay {
    @apply absolute bottom-0 bg-gradient-to-t from-black/90 via-black/80 to-transparent text-white w-full transition-all duration-300 opacity-90 translate-y-0 text-sm font-medium text-center px-3 py-4 flex items-end justify-center rounded-b-lg;
    min-height: 40%;
}
</style>
