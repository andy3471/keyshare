<template>
    <AuthLayout>
        <Head title="Register" />

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                    Name
                </label>
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    required
                    autofocus
                    class="form-control w-full"
                    :class="{ 'border-danger': form.errors.name }"
                />
                <div v-if="form.errors.name" class="mt-1 text-sm text-danger">
                    {{ form.errors.name }}
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                    E-Mail Address
                </label>
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    required
                    class="form-control w-full"
                    :class="{ 'border-danger': form.errors.email }"
                />
                <div v-if="form.errors.email" class="mt-1 text-sm text-danger">
                    {{ form.errors.email }}
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                    Password
                </label>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    required
                    class="form-control w-full"
                    :class="{ 'border-danger': form.errors.password }"
                />
                <div v-if="form.errors.password" class="mt-1 text-sm text-danger">
                    {{ form.errors.password }}
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                    Confirm Password
                </label>
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    required
                    class="form-control w-full"
                />
            </div>

            <div class="flex items-center justify-between">
                <button
                    type="submit"
                    class="btn-accent"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing">Registering...</span>
                    <span v-else>Register</span>
                </button>

                <Link
                    :href="login.url()"
                    class="text-sm text-accent-400 hover:text-accent-300"
                >
                    Already registered?
                </Link>
            </div>
        </form>
    </AuthLayout>
</template>

<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { register, login } from '@/routes';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(register.url(), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
