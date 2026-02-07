<template>
    <AppLayout v-if="keyData" :title="`${keyData.platform?.name} - ${keyData.name}`">
        <Head :title="`${keyData.platform?.name} - ${keyData.name || 'Key'}`" />
        <div class="max-w-4xl mx-auto px-4 py-6">
            <div v-if="flash.error" class="mb-4 bg-danger text-white px-4 py-3 rounded">
                {{ flash.error }}
            </div>

            <form @submit.prevent="claimKey" class="mb-6">
                <input type="hidden" name="_token" :value="csrfToken" />

                <div v-if="keyData.owned_user_id === null" class="space-y-4">
                    <input
                        name="key"
                        class="border border-dark-600 rounded-lg bg-dark-800 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full opacity-60 cursor-not-allowed bg-dark-900"
                        type="text"
                        value="*****-*****-*****-*****"
                        disabled
                    />
                    <input type="hidden" name="id" :value="keyData.id" />
                    <button
                        type="submit"
                        class="bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-2.5 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5 active:translate-y-0"
                    >
                        Claim Key
                    </button>
                    <p class="text-gray-400 text-sm mt-2">Click to claim this key</p>
                </div>

                <div v-else-if="keyData.owned_user_id === auth.user?.id" class="space-y-4">
                    <input
                        name="key"
                        class="border border-dark-600 rounded-lg bg-dark-800 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full opacity-60 cursor-not-allowed bg-dark-900"
                        type="text"
                        :value="keyData.keycode"
                        disabled
                    />
                    <a
                        v-if="keyData.platform?.name === 'Steam'"
                        :href="`https://store.steampowered.com/account/registerkey?key=${keyData.keycode}`"
                        target="_blank"
                        class="text-accent-400 hover:text-accent-300 underline"
                    >
                        Redeem on Steam
                    </a>
                </div>

                <div v-else class="space-y-4">
                    <input
                        name="key"
                        class="border border-dark-600 rounded-lg bg-dark-800 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full opacity-60 cursor-not-allowed bg-dark-900"
                        type="text"
                        value="*****-*****-*****-*****"
                        disabled
                    />
                    <button
                        type="submit"
                        class="bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-2.5 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5 active:translate-y-0 opacity-50 cursor-not-allowed"
                        disabled
                    >
                        Claim Key
                    </button>
                    <p class="text-gray-400 text-sm mt-2">This key has already been claimed</p>
                </div>
            </form>

            <div v-if="keyData.message" class="mb-6 p-4 bg-dark-800 rounded-lg border border-dark-700">
                <p class="text-gray-300 font-semibold mb-2">Message from sharer:</p>
                <p class="text-gray-400">{{ keyData.message }}</p>
            </div>

            <div class="bg-dark-800 rounded-lg border border-dark-700 p-6">
                <p class="text-gray-300 font-semibold mb-4">Shared by:</p>
                <div class="flex items-start space-x-4">
                    <Link :href="`/users/${keyData.createdUser?.id}`" class="relative">
                        <img
                            :src="keyData.createdUser?.image || '/images/default-avatar.png'"
                            :alt="keyData.createdUser?.name"
                            class="w-24 h-24 rounded-full border-2 border-dark-600"
                        />
                        <div class="absolute -bottom-2 -right-2">
                            <span
                                :class="[
                                    'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold shadow-md',
                                    keyData.createdUser?.karma_colour === 'badge-danger' ? 'bg-danger text-white shadow-danger/30' :
                                    keyData.createdUser?.karma_colour === 'badge-warning' ? 'bg-warning text-white shadow-warning/30' :
                                    keyData.createdUser?.karma_colour === 'badge-info' ? 'bg-primary-600 text-white shadow-primary-600/30' :
                                    'bg-success text-white shadow-success/30'
                                ]"
                            >
                                {{ keyData.createdUser?.karma }}
                            </span>
                        </div>
                    </Link>
                    <div class="flex-1">
                        <h5 class="text-lg font-semibold text-white mb-2">
                            <Link
                                :href="`/users/${keyData.createdUser?.id}`"
                                class="text-accent-400 hover:text-accent-300"
                            >
                                {{ keyData.createdUser?.name }}
                            </Link>
                        </h5>
                        <p v-if="keyData.createdUser?.bio" class="text-gray-400">{{ keyData.createdUser.bio }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
    <AppLayout v-else title="Loading...">
        <div class="max-w-4xl mx-auto px-4 py-6">
            <p class="text-gray-400">Loading key...</p>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { computed, watch } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { KeyData } from '@/Types/generated';
import keys from '@/routes/keys';

interface Props {
    keyData: KeyData;
}

const props = defineProps<Props>();

// Access the keyData prop directly
const keyData = computed(() => props.keyData);

const page = usePage();
const auth = (page.props.auth as { user: any | null }) || { user: null };
const flash = (page.props.flash as { message?: string; error?: string }) || {};

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

const form = useForm({
    id: keyData.value?.id ?? 0,
});

// Watch for changes to key.id and update form
watch(() => keyData.value?.id, (newId) => {
    if (newId) {
        form.id = newId;
    }
});

const claimKey = () => {
    if (!keyData.value?.id) return;
    
    form.post(keys.claim.url(), {
        preserveScroll: true,
    });
};
</script>
