<template>
    <AppLayout :title="user.name">
        <div class="max-w-4xl mx-auto px-4 py-6">
            <div class="bg-dark-800 rounded-lg border border-dark-700 p-6">
                <div class="flex items-start space-x-6">
                    <img
                        :src="user.image || '/images/default-avatar.png'"
                        :alt="user.name"
                        class="w-32 h-32 rounded-full border-2 border-dark-600"
                    />
                    <div class="flex-1">
                        <h5 class="text-2xl font-semibold text-white mb-2">
                            {{ user.name }}
                            <span
                                :class="[
                                    'badge ml-2',
                                    user.karma_colour === 'badge-danger' ? 'badge-danger' :
                                    user.karma_colour === 'badge-warning' ? 'badge-warning' :
                                    user.karma_colour === 'badge-info' ? 'badge-info' :
                                    'badge-success'
                                ]"
                            >
                                {{ user.karma }}
                            </span>
                        </h5>
                        <p v-if="user.bio" class="text-gray-300 mb-4">{{ user.bio }}</p>
                        <Link
                            v-if="user.id === auth.user?.id"
                            :href="users.edit.url(user.id)"
                            class="text-accent-400 hover:text-accent-300 underline"
                        >
                            Update Profile
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { UserData } from '@/Types/generated';
import users from '@/routes/users';

interface Props {
    user: UserData;
}

defineProps<Props>();

const page = usePage();
const auth = (page.props.auth as { user: any | null }) || { user: null };
</script>
