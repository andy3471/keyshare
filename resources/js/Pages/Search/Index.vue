<template>
    <AppLayout :title="title">
        <GameList :games="games" />
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import GameList from '@/Components/GameList.vue';

interface Props {
    title: string;
    games: {
        data: Array<{ id: number; name: string; image?: string; url: string }>;
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
}

defineProps<Props>();
</script>
