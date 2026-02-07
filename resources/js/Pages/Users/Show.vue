<template>
    <AppLayout :title="user.name">
        <div class="max-w-4xl mx-auto px-4 py-6">
            <div class="bg-dark-800 rounded-lg border border-dark-700 p-6 shadow-lg transition-all duration-300 hover:border-accent-500/50 hover:shadow-xl hover:shadow-accent-500/10">
                <div class="flex flex-col sm:flex-row items-start space-y-4 sm:space-y-0 sm:space-x-6">
                    <div class="relative">
                        <img
                            :src="user.image || '/images/default-avatar.png'"
                            :alt="user.name"
                            class="w-32 h-32 rounded-full border-4 border-dark-600 shadow-lg"
                        />
                        <div class="absolute -bottom-2 -right-2">
                            <span
                                :class="[
                                    'inline-flex items-center px-4 py-2 rounded-full text-lg font-semibold shadow-md',
                                    user.karma_colour === 'badge-danger' ? 'bg-danger text-white shadow-danger/30' :
                                    user.karma_colour === 'badge-warning' ? 'bg-warning text-white shadow-warning/30' :
                                    user.karma_colour === 'badge-info' ? 'bg-primary-600 text-white shadow-primary-600/30' :
                                    'bg-success text-white shadow-success/30'
                                ]"
                            >
                                {{ user.karma }}
                            </span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-white mb-3">
                            {{ user.name }}
                        </h1>
                        <p v-if="user.bio" class="text-gray-300 mb-6 leading-relaxed">{{ user.bio }}</p>
                        <Link
                            v-if="user.id === auth.user?.id"
                            :href="users.edit.url(user.id)"
                            class="bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-2.5 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5 active:translate-y-0 inline-flex items-center"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
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
