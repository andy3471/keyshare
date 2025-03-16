<script lang="ts" setup>
// const props = defineProps<{game: GameResource}>();
import TextLink from '@/components/TextLink.vue';
</script>

<template>
    <TextLink class="relative aspect-[2/3] overflow-hidden rounded-xl border border-muted bg-card shadow">
        <img
            src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fstatic0.gamerantimages.com%2Fwordpress%2Fwp-content%2Fuploads%2F2020%2F02%2FHeavy-Rain-Box-Art.jpg&f=1&nofb=1&ipt=72c3aae26ae3dac032622bddb3f3c6376f8d12a81a25b5c2ccf807e5fd8cfd4e&ipo=images"
            alt="Game Box Art"
            class="absolute inset-0 h-full w-full object-cover"
        />

        <div class="absolute bottom-0 w-full bg-muted/30 backdrop-blur-md p-4 text-center text-sm font-semibold text-foreground">
            Game Title
        </div>
    </TextLink>
</template>
