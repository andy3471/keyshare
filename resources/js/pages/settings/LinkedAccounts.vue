<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Linked Account settings',
        href: '/settings/linked-accounts',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Linked Account settings" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Linked Account settings" description="Update your linked account settings" />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
