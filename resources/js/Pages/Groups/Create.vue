<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import FormInput from '@/Components/ui/FormInput.vue';
import FormTextarea from '@/Components/ui/FormTextarea.vue';
import AppSwitch from '@/Components/ui/AppSwitch.vue';
import AvatarUpload from '@/Components/shared/AvatarUpload.vue';
import LoadingSpinner from '@/Components/ui/LoadingSpinner.vue';
import groups from '@/routes/groups';

const form = useForm({
  name: '',
  description: '',
  is_public: false,
  avatar: null as File | null,
});

const initials = computed(() => form.name ? form.name.charAt(0).toUpperCase() : '?');

const handleAvatarChange = (file: File) => {
  form.avatar = file;
};

const submit = () => {
  form.post(groups.store.url(), { forceFormData: true });
};
</script>

<template>
  <AppLayout title="Create Group">
    <Head title="Create Group" />
    <div class="max-w-2xl mx-auto px-4 py-6">
      <div class="bg-dark-800 rounded-xl p-6 border border-dark-700">
        <h2 class="text-xl font-display font-bold text-white mb-6">
          Create a New Group
        </h2>

        <form
          class="space-y-6"
          @submit.prevent="submit"
        >
          <AvatarUpload
            :initials="initials"
            :error="form.errors.avatar"
            label="Group Avatar"
            @update:file="handleAvatarChange"
          >
            <template #label-suffix>
              <span class="text-gray-500"> (optional)</span>
            </template>
          </AvatarUpload>

          <FormInput
            id="name"
            v-model="form.name"
            label="Group Name"
            placeholder="Enter a group name..."
            :error="form.errors.name"
            :maxlength="50"
            required
          />

          <FormTextarea
            id="description"
            v-model="form.description"
            label="Description"
            placeholder="What is this group about?"
            :error="form.errors.description"
            :maxlength="1000"
          >
            <template #label-suffix>
              <span class="text-gray-500"> (optional)</span>
            </template>
          </FormTextarea>

          <AppSwitch
            v-model="form.is_public"
            label="Public Group"
            description="Anyone can find and join a public group"
          />

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
              Create Group
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
