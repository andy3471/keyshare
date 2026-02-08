<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ConfirmModal from '@/Components/ConfirmModal.vue';
import { update as updateRoute, destroy as destroyRoute } from '@/routes/groups';
import { GroupData } from '@/Types/generated';

interface Props {
  group: GroupData;
}

const props = defineProps<Props>();

const form = useForm({
  _method: 'PUT',
  name: props.group.name,
  description: props.group.description ?? '',
  is_public: props.group.is_public ?? false,
  avatar: null as File | null,
  discord_webhook_url: props.group.discord_webhook_url ?? '',
  min_karma: props.group.min_karma,
});

const avatarPreview = ref<string | null>(null);
const currentAvatar = computed(() => props.group.avatar);

const initials = computed(() => {
  return form.name ? form.name.charAt(0).toUpperCase() : '?';
});

const handleAvatarChange = (event: Event) => {
  const file = (event.target as HTMLInputElement).files?.[0];
  if (file) {
    form.avatar = file;
    avatarPreview.value = URL.createObjectURL(file);
  }
};

const submit = () => {
  form.post(updateRoute.url(props.group.id), {
    forceFormData: true,
  });
};

const showDeleteModal = ref(false);

const deleteGroup = () => {
  showDeleteModal.value = false;
  router.delete(destroyRoute.url(props.group.id));
};
</script>

<template>
  <AppLayout title="Edit Group">
    <Head :title="`Edit ${group.name}`" />
    <div class="max-w-2xl mx-auto px-4 py-6 space-y-6">
      <!-- Edit Form -->
      <div class="bg-dark-800 rounded-xl p-6 border border-dark-700">
        <h2 class="text-xl font-display font-bold text-white mb-6">
          Group Settings
        </h2>

        <form
          class="space-y-6"
          @submit.prevent="submit"
        >
          <!-- Avatar -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-3">
              Group Avatar
            </label>
            <div class="flex items-center gap-4">
              <div class="relative">
                <div
                  v-if="avatarPreview || currentAvatar"
                  class="w-20 h-20 rounded-xl overflow-hidden border-2 border-dark-600"
                >
                  <img
                    :src="avatarPreview ?? currentAvatar ?? ''"
                    alt="Group avatar"
                    class="w-full h-full object-cover"
                  >
                </div>
                <div
                  v-else
                  class="w-20 h-20 rounded-xl bg-accent-600/20 border-2 border-dark-600 flex items-center justify-center"
                >
                  <span class="text-accent-400 font-bold text-2xl">{{ initials }}</span>
                </div>
              </div>
              <div>
                <label
                  for="avatar"
                  class="inline-flex items-center px-4 py-2 bg-dark-700 hover:bg-dark-600 text-gray-300 text-sm font-medium rounded-lg transition-colors cursor-pointer"
                >
                  <svg
                    class="w-4 h-4 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                    />
                  </svg>
                  {{ currentAvatar ? 'Change Image' : 'Upload Image' }}
                  <input
                    id="avatar"
                    type="file"
                    accept="image/*"
                    class="hidden"
                    @change="handleAvatarChange"
                  >
                </label>
                <p class="text-xs text-gray-500 mt-1">
                  JPG, PNG or GIF. Max 2MB.
                </p>
              </div>
            </div>
            <p
              v-if="form.errors.avatar"
              class="mt-1 text-sm text-danger-400"
            >
              {{ form.errors.avatar }}
            </p>
          </div>

          <!-- Name -->
          <div>
            <label
              for="name"
              class="block text-sm font-medium text-gray-300 mb-2"
            >
              Group Name
            </label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              class="w-full bg-dark-900 border border-dark-600 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:border-accent-500 focus:ring-1 focus:ring-accent-500 transition-colors"
              required
            >
            <p
              v-if="form.errors.name"
              class="mt-1 text-sm text-danger-400"
            >
              {{ form.errors.name }}
            </p>
          </div>

          <!-- Description -->
          <div>
            <label
              for="description"
              class="block text-sm font-medium text-gray-300 mb-2"
            >
              Description
              <span class="text-gray-500">(optional)</span>
            </label>
            <textarea
              id="description"
              v-model="form.description"
              rows="3"
              class="w-full bg-dark-900 border border-dark-600 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:border-accent-500 focus:ring-1 focus:ring-accent-500 transition-colors resize-none"
            />
            <p
              v-if="form.errors.description"
              class="mt-1 text-sm text-danger-400"
            >
              {{ form.errors.description }}
            </p>
          </div>

          <!-- Public toggle -->
          <div class="flex items-center justify-between">
            <div>
              <label
                for="is_public"
                class="text-sm font-medium text-gray-300"
              >
                Public Group
              </label>
              <p class="text-xs text-gray-500 mt-0.5">
                Anyone can find and join a public group
              </p>
            </div>
            <button
              id="is_public"
              type="button"
              class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-accent-500 focus:ring-offset-2 focus:ring-offset-dark-800"
              :class="form.is_public ? 'bg-accent-600' : 'bg-dark-600'"
              role="switch"
              :aria-checked="form.is_public"
              @click="form.is_public = !form.is_public"
            >
              <span
                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                :class="form.is_public ? 'translate-x-5' : 'translate-x-0'"
              />
            </button>
          </div>

          <!-- Discord Integration -->
          <div class="border-t border-dark-700 pt-6">
            <div class="flex items-center gap-3 mb-4">
              <svg
                class="w-5 h-5 text-[#5865F2]"
                viewBox="0 0 24 24"
                fill="currentColor"
              >
                <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028 14.09 14.09 0 0 0 1.226-1.994.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z" />
              </svg>
              <h3 class="text-sm font-semibold text-white">
                Discord Integration
              </h3>
            </div>
            <div>
              <label
                for="discord_webhook_url"
                class="block text-sm font-medium text-gray-300 mb-2"
              >
                Webhook URL
                <span class="text-gray-500">(optional)</span>
              </label>
              <input
                id="discord_webhook_url"
                v-model="form.discord_webhook_url"
                type="url"
                placeholder="https://discord.com/api/webhooks/..."
                class="w-full bg-dark-900 border border-dark-600 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:border-accent-500 focus:ring-1 focus:ring-accent-500 transition-colors"
              >
              <p class="text-xs text-gray-500 mt-1.5">
                Get notified in Discord when keys are shared or claimed. Create a webhook in your Discord channel's settings under Integrations → Webhooks.
              </p>
              <p
                v-if="form.errors.discord_webhook_url"
                class="mt-1 text-sm text-danger-400"
              >
                {{ form.errors.discord_webhook_url }}
              </p>
              <div
                v-if="form.discord_webhook_url"
                class="mt-2 flex items-center gap-2 text-xs"
              >
                <span class="inline-flex items-center gap-1 text-success">
                  <svg
                    class="w-3.5 h-3.5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 13l4 4L19 7"
                    />
                  </svg>
                  Discord notifications enabled
                </span>
              </div>
            </div>
          </div>

          <!-- Karma Requirement -->
          <div class="border-t border-dark-700 pt-6">
            <div class="flex items-center gap-3 mb-4">
              <svg
                class="w-5 h-5 text-warning"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 10V3L4 14h7v7l9-11h-7z"
                />
              </svg>
              <h3 class="text-sm font-semibold text-white">
                Karma Requirement
              </h3>
            </div>
            <div>
              <label
                for="min_karma"
                class="block text-sm font-medium text-gray-300 mb-2"
              >
                Minimum karma to claim keys
                <span class="text-gray-500">(optional)</span>
              </label>
              <input
                id="min_karma"
                v-model.number="form.min_karma"
                type="number"
                placeholder="No minimum"
                class="w-full bg-dark-900 border border-dark-600 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:border-accent-500 focus:ring-1 focus:ring-accent-500 transition-colors"
              >
              <p class="text-xs text-gray-500 mt-1.5">
                Members with karma below this threshold won't be able to claim keys in this group. Leave empty for no restriction.
              </p>
              <p
                v-if="form.errors.min_karma"
                class="mt-1 text-sm text-danger-400"
              >
                {{ form.errors.min_karma }}
              </p>
            </div>
          </div>

          <!-- Submit -->
          <div class="flex justify-end">
            <button
              type="submit"
              :disabled="form.processing"
              class="inline-flex items-center px-6 py-2.5 bg-accent-600 hover:bg-accent-500 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-medium rounded-lg transition-colors"
            >
              Save Changes
            </button>
          </div>
        </form>
      </div>

      <!-- Danger Zone -->
      <div
        v-if="group.can?.delete"
        class="bg-dark-800 rounded-xl p-6 border border-danger-600/30"
      >
        <h2 class="text-lg font-semibold text-danger-400 mb-2">
          Danger Zone
        </h2>
        <p class="text-gray-400 text-sm mb-4">
          Deleting the group will permanently remove all data associated with it. Keys shared within this group will become ungrouped.
        </p>
        <button
          class="px-4 py-2 bg-danger-600 hover:bg-danger-500 text-white text-sm font-medium rounded-lg transition-colors"
          @click="showDeleteModal = true"
        >
          Delete Group
        </button>
      </div>
    </div>

    <!-- Delete Group Modal -->
    <ConfirmModal
      :open="showDeleteModal"
      title="Delete group"
      message="Are you sure you want to permanently delete this group? All keys and members will be removed. This action cannot be undone."
      confirm-label="Delete group"
      variant="danger"
      @confirm="deleteGroup"
      @cancel="showDeleteModal = false"
    />
  </AppLayout>
</template>
