<template>
  <AppLayout title="Add Key">
    <Head title="Add Key" />
    <div class="max-w-4xl mx-auto px-4 py-6">
      <AddKey
        :platforms="platforms"
      />
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AddKey from '@/Components/AddKey.vue';
import { PlatformData } from '@/Types/generated';

interface Props {
  platforms: PlatformData[];
}

defineProps<Props>();
</script>
