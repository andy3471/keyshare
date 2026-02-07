<template>
    <AppLayout :title="auth.user?.name || 'Edit Profile'">
        <div class="max-w-2xl mx-auto px-4 py-6">
            <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-4">
                <div v-if="Object.keys(form.errors).length > 0" class="bg-danger text-white px-4 py-3 rounded">
                    <div v-for="(error, field) in form.errors" :key="field">
                        {{ Array.isArray(error) ? error[0] : error }}
                    </div>
                </div>

                <div class="flex justify-center mb-4">
                    <img
                        :src="auth.user?.image || '/images/default-avatar.png'"
                        :alt="auth.user?.name"
                        class="w-48 h-48 rounded-full border-2 border-dark-600"
                    />
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-300 mb-2">
                        Image (1:1 ratio required):
                    </label>
                    <input
                        id="image"
                        @input="form.image = $event.target.files[0]"
                        type="file"
                        accept="image/*"
                        class="border border-dark-600 rounded-lg bg-dark-800 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full"
                    />
                    <div v-if="form.errors.image" class="mt-1 text-sm text-danger">
                        {{ form.errors.image }}
                    </div>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                        Name:
                    </label>
                    <input
                        id="name"
                        v-model="form.name"
                        name="name"
                        type="text"
                        required
                        class="border border-dark-600 rounded-lg bg-dark-800 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full"
                    />
                    <div v-if="form.errors.name" class="mt-1 text-sm text-danger">
                        {{ form.errors.name }}
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                        Email:
                    </label>
                    <input
                        id="email"
                        v-model="form.email"
                        name="email"
                        type="email"
                        class="border border-dark-600 rounded-lg bg-dark-800 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full"
                    />
                    <div v-if="form.errors.email" class="mt-1 text-sm text-danger">
                        {{ form.errors.email }}
                    </div>
                </div>

                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-300 mb-2">
                        Bio:
                    </label>
                    <textarea
                        id="bio"
                        v-model="form.bio"
                        name="bio"
                        rows="4"
                        class="border border-dark-600 rounded-lg bg-dark-800 text-gray-100 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500 w-full"
                    />
                    <div v-if="form.errors.bio" class="mt-1 text-sm text-danger">
                        {{ form.errors.bio }}
                    </div>
                </div>

                <button
                    type="submit"
                    class="bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-2.5 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing">Saving...</span>
                    <span v-else>Save</span>
                </button>
            </form>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import users from '@/routes/users';

const page = usePage();
const auth = (page.props.auth as { user: any | null }) || { user: null };

const form = useForm({
    name: auth.user?.name || '',
    email: auth.user?.email || '',
    bio: auth.user?.bio || '',
    image: null as File | null,
});

const submit = () => {
    form.post(users.update.url(auth.user?.id), {
        preserveScroll: true,
        forceFormData: true,
    });
};
</script>
