<template>
    <div ref="trigger" class="infinite-loading-trigger"></div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

interface Props {
    spinner?: string;
}

const props = withDefaults(defineProps<Props>(), {
    spinner: 'waveDots',
});

const emit = defineEmits<{
    infinite: [state: { loaded: () => void; complete: () => void }];
}>();

const trigger = ref<HTMLElement | null>(null);
let observer: IntersectionObserver | null = null;
let isLoading = false;
let isComplete = false;

const state = {
    loaded: () => {
        isLoading = false;
    },
    complete: () => {
        isComplete = true;
        if (observer && trigger.value) {
            observer.unobserve(trigger.value);
        }
    },
};

const handleIntersection = (entries: IntersectionObserverEntry[]) => {
    if (isLoading || isComplete) return;

    const entry = entries[0];
    if (entry.isIntersecting) {
        isLoading = true;
        emit('infinite', state);
    }
};

onMounted(() => {
    if (!trigger.value) return;

    observer = new IntersectionObserver(handleIntersection, {
        root: null,
        rootMargin: '100px',
        threshold: 0.1,
    });

    observer.observe(trigger.value);
});

onUnmounted(() => {
    if (observer && trigger.value) {
        observer.unobserve(trigger.value);
    }
});
</script>

<style scoped>
.infinite-loading-trigger {
    height: 1px;
    width: 100%;
}
</style>
