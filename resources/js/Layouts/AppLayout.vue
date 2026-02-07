<template>
    <div class="min-h-screen bg-dark-950">
        <Navbar />

        <TitleHeader v-if="title" :title="title" />

        <FlashMessages />

        <main class="page-container">
            <slot />
        </main>
    </div>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import TitleHeader from '@/Components/TitleHeader.vue';
import FlashMessages from '@/Components/FlashMessages.vue';

interface Props {
    title?: string;
}

defineProps<Props>();

const page = usePage();
</script>
