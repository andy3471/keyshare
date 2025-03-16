<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import GameTile from '@/components/games/GameTile.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Groups',
        href: '/groups',
    },
];
</script>

<template>
    <Head title="Groups" />

    <AppLayout :breadcrumbs="breadcrumbs">
    </AppLayout>
</template>
