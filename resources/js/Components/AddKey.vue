<template>
    <div class="space-y-6">
        <AddKeyGame :platforms="platforms" />
    </div>
</template>

<script setup lang="ts">
import AddKeyGame from './AddKeyGame.vue';
import { PlatformData } from '@/Types/generated';

interface Props {
    platforms: PlatformData[];
}

defineProps<Props>();
</script>
