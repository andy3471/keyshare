<template>
    <nav class="bg-dark-900 border-b-2 border-accent-600 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <Link :href="index.url()" class="text-white text-xl font-display font-bold">
                        {{ appName }}
                    </Link>
                </div>

                <div v-if="auth?.user" class="flex items-center space-x-4">
                    <!-- Games Link -->
                    <Link :href="games.index.url()" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        Games
                    </Link>

                    <!-- Platforms Dropdown -->
                    <div class="relative group">
                        <button class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                            Platforms
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 bg-dark-800 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-dark-700">
                            <div class="py-1">
                                <Link
                                    v-for="platform in platformsList"
                                    :key="platform.id"
                                    :href="platformsRoutes.show.url(platform.id)"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-accent-600 hover:text-white transition-colors"
                                >
                                    {{ platform.name }}
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Add Key Link -->
                    <Link :href="keys.create.url()" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        Add Key
                    </Link>

                    <!-- Search -->
                    <form :action="search.index.url()" method="GET" class="flex items-center">
                        <input
                            type="search"
                            name="search"
                            placeholder="Search..."
                            class="w-80 bg-dark-700 border border-dark-600 text-gray-100 rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                        />
                    </form>

                    <!-- Admin Link -->
                    <Link
                        v-if="auth.user?.admin"
                        href="/admin"
                        class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors"
                    >
                        Admin
                    </Link>

                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <img
                                :src="auth?.user?.image || '/images/default-avatar.png'"
                                :alt="auth?.user?.name"
                                class="h-6 w-6 rounded-full"
                            />
                            <span>{{ auth?.user?.name }}</span>
                            <span
                                :class="[
                                    'badge',
                                    auth?.user?.karma_colour === 'badge-danger' ? 'badge-danger' :
                                    auth?.user?.karma_colour === 'badge-warning' ? 'badge-warning' :
                                    auth?.user?.karma_colour === 'badge-info' ? 'badge-info' :
                                    'badge-success'
                                ]"
                            >
                                {{ auth?.user?.karma }}
                            </span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-56 bg-dark-800 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-dark-700">
                            <div class="py-1">
                                <Link
                                    v-if="auth?.user?.id"
                                    :href="users.show.url(auth.user.id)"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-accent-600 hover:text-white transition-colors"
                                >
                                    View Profile
                                </Link>
                                <Link
                                    v-if="auth?.user?.id"
                                    :href="users.edit.url(auth.user.id)"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-accent-600 hover:text-white transition-colors"
                                >
                                    Update Profile
                                </Link>
                                <div class="border-t border-dark-700 my-1"></div>
                                <Link
                                    :href="keys.claimed.index.url()"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-accent-600 hover:text-white transition-colors"
                                >
                                    Claimed Keys
                                </Link>
                                <Link
                                    :href="keys.shared.index.url()"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-accent-600 hover:text-white transition-colors"
                                >
                                    Shared Keys
                                </Link>
                                <div class="border-t border-dark-700 my-1"></div>
                                <Link
                                    :href="passwordReset.request.url()"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-accent-600 hover:text-white transition-colors"
                                >
                                    Change Password
                                </Link>
                                <form :action="logoutRoute.url()" method="POST" @submit.prevent="logout">
                                    <input type="hidden" name="_token" :value="csrfToken" />
                                    <button
                                        type="submit"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-300 hover:bg-accent-600 hover:text-white transition-colors"
                                    >
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="flex items-center space-x-4">
                    <Link :href="login.url()" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        Login
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { index, logout as logoutRoute, login } from '@/routes';
import games from '@/routes/games';
import platformsRoutes from '@/routes/platforms';
import keys from '@/routes/keys';
import users from '@/routes/users';
import search from '@/routes/search';
import passwordReset from '@/routes/password/reset';
import loginLinkedAccount from '@/routes/login';

const page = usePage();
// Ensure auth is always defined, even if user is null
const auth = (page.props.auth as { user: any | null } | undefined) ?? { user: null };
const platformsList = (page.props.platforms as Array<{ id: number; name: string }> | undefined) || [];
const appName = 'Keyshare';

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

const logout = () => {
    const form = useForm({});
    form.post(logoutRoute.url());
};
</script>
