<template>
    <div class="title-header">
        {{ title }}
    </div>
</template>

<script setup lang="ts">
interface Props {
    title: string;
}

defineProps<Props>();
</script>
