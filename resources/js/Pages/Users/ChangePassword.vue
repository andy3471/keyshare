<template>
    <AppLayout title="Change Password">
        <div class="max-w-2xl mx-auto px-4 py-6">
            <form @submit.prevent="submit" class="space-y-4">
                <div v-if="Object.keys(form.errors).length > 0" class="bg-danger text-white px-4 py-3 rounded">
                    <div v-for="(error, field) in form.errors" :key="field">
                        {{ Array.isArray(error) ? error[0] : error }}
                    </div>
                </div>

                <div>
                    <label for="currentpassword" class="block text-sm font-medium text-gray-300 mb-2">
                        Current Password:
                    </label>
                    <input
                        id="currentpassword"
                        v-model="form.currentpassword"
                        type="password"
                        required
                        class="form-control w-full"
                    />
                    <div v-if="form.errors.currentpassword" class="mt-1 text-sm text-danger">
                        {{ form.errors.currentpassword }}
                    </div>
                </div>

                <div>
                    <label for="newpassword" class="block text-sm font-medium text-gray-300 mb-2">
                        New Password:
                    </label>
                    <input
                        id="newpassword"
                        v-model="form.newpassword"
                        type="password"
                        required
                        class="form-control w-full"
                    />
                    <div v-if="form.errors.newpassword" class="mt-1 text-sm text-danger">
                        {{ form.errors.newpassword }}
                    </div>
                </div>

                <div>
                    <label for="newpassword_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                        Confirm New Password:
                    </label>
                    <input
                        id="newpassword_confirmation"
                        v-model="form.newpassword_confirmation"
                        type="password"
                        required
                        class="form-control w-full"
                    />
                    <div v-if="form.errors.newpassword_confirmation" class="mt-1 text-sm text-danger">
                        {{ form.errors.newpassword_confirmation }}
                    </div>
                </div>

                <button
                    type="submit"
                    class="btn-accent"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing">Changing...</span>
                    <span v-else>Change Password</span>
                </button>
            </form>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import passwordReset from '@/routes/password/reset';

const form = useForm({
    currentpassword: '',
    newpassword: '',
    newpassword_confirmation: '',
});

const submit = () => {
    form.post(passwordReset.save.url(), {
        preserveScroll: true,
        onFinish: () => form.reset(),
    });
};
</script>
