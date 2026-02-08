<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import FormInput from '@/Components/ui/FormInput.vue';
import FormTextarea from '@/Components/ui/FormTextarea.vue';
import AvatarUpload from '@/Components/shared/AvatarUpload.vue';
import LoadingSpinner from '@/Components/ui/LoadingSpinner.vue';
import { UserData } from '@/Types/generated';
import users from '@/routes/users';

interface Props {
  user: UserData;
}

const props = defineProps<Props>();

const form = useForm({
  _method: 'PUT',
  name: props.user.name,
  email: props.user.email,
  bio: props.user.bio ?? '',
  avatar: null as File | null,
  password: '',
  password_confirmation: '',
});

const initials = computed(() => form.name ? form.name.charAt(0).toUpperCase() : '?');

const handleAvatarChange = (file: File) => {
  form.avatar = file;
};

const submit = () => {
  form.post(users.update.url(props.user.id), { forceFormData: true });
};
</script>

<template>
  <AppLayout title="Edit Profile">
    <Head title="Edit Profile" />
    <div class="max-w-2xl mx-auto px-4 py-6 space-y-6">
      <div class="bg-dark-800 rounded-xl p-6 border border-dark-700">
        <h2 class="text-xl font-display font-bold text-white mb-6">
          Edit Profile
        </h2>

        <form
          class="space-y-6"
          @submit.prevent="submit"
        >
          <AvatarUpload
            :current-image="user.avatar"
            :initials="initials"
            shape="round"
            :error="form.errors.avatar"
            label="Profile Picture"
            @update:file="handleAvatarChange"
          />

          <FormInput
            id="name"
            v-model="form.name"
            label="Name"
            :error="form.errors.name"
            required
          />

          <FormInput
            id="email"
            v-model="form.email"
            label="Email"
            type="email"
            :error="form.errors.email"
            required
          />

          <FormTextarea
            id="bio"
            v-model="form.bio"
            label="Bio"
            placeholder="Tell people a bit about yourself..."
            :error="form.errors.bio"
          >
            <template #label-suffix>
              <span class="text-gray-500"> (optional)</span>
            </template>
          </FormTextarea>

          <div class="border-t border-dark-700 pt-6">
            <h3 class="text-sm font-semibold text-white mb-4">
              Change Password
            </h3>
            <div class="space-y-4">
              <FormInput
                id="password"
                v-model="form.password"
                label="New Password"
                type="password"
                :error="form.errors.password"
                hint="Leave blank to keep your current password"
                autocomplete="new-password"
              />
              <FormInput
                id="password_confirmation"
                v-model="form.password_confirmation"
                label="Confirm New Password"
                type="password"
                :error="form.errors.password_confirmation"
                autocomplete="new-password"
              />
            </div>
          </div>

          <div class="flex justify-end">
            <button
              type="submit"
              :disabled="form.processing"
              class="inline-flex items-center px-6 py-2.5 bg-accent-600 hover:bg-accent-500 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-medium rounded-lg transition-colors"
            >
              <LoadingSpinner
                v-if="form.processing"
                size="sm"
                class="-ml-1 mr-2"
              />
              Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
