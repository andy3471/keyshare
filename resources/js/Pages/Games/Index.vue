<template>
    <AppLayout :title="title">
        <Head :title="title" />
        <div class="max-w-7xl mx-auto px-4 py-6">
            <GameFilters :platforms="platforms" :selected-platforms="selectedPlatforms" />
            <GameList :games="games" />
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import GameList from '@/Components/GameList.vue';
import GameFilters from '@/Components/GameFilters.vue';
import { PlatformData } from '@/Types/generated';

interface Props {
    title: string;
    games: {
        data: Array<{ id: number; name: string; image?: string; url: string; hasKey?: boolean; keyCount?: number }>;
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    selectedPlatforms?: string[];
}

const props = defineProps<Props>();

const page = usePage();
const platforms = (page.props.platforms as PlatformData[] | undefined) || [];
const selectedPlatforms = props.selectedPlatforms || [];
</script>
