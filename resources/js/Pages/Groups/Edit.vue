<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import FormInput from '@/Components/ui/FormInput.vue';
import FormTextarea from '@/Components/ui/FormTextarea.vue';
import AppSwitch from '@/Components/ui/AppSwitch.vue';
import AvatarUpload from '@/Components/shared/AvatarUpload.vue';
import DiscordWebhookSection from '@/Components/groups/DiscordWebhookSection.vue';
import KarmaRequirementSection from '@/Components/groups/KarmaRequirementSection.vue';
import ClaimCooldownSection from '@/Components/groups/ClaimCooldownSection.vue';
import DangerZone from '@/Components/groups/DangerZone.vue';
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
  claim_cooldown_minutes: props.group.claim_cooldown_minutes,
});

const initials = computed(() => form.name ? form.name.charAt(0).toUpperCase() : '?');

const handleAvatarChange = (file: File) => {
  form.avatar = file;
};

const submit = () => {
  form.post(updateRoute.url(props.group.id), { forceFormData: true });
};

const deleteGroup = () => {
  router.delete(destroyRoute.url(props.group.id));
};
</script>

<template>
  <AppLayout title="Edit Group">
    <Head :title="`Edit ${group.name}`" />
    <div class="max-w-2xl mx-auto px-4 py-6 space-y-6">
      <div class="bg-dark-800 rounded-xl p-6 border border-dark-700">
        <h2 class="text-xl font-display font-bold text-white mb-6">
          Group Settings
        </h2>

        <form
          class="space-y-6"
          @submit.prevent="submit"
        >
          <AvatarUpload
            :current-image="group.avatar"
            :initials="initials"
            :error="form.errors.avatar"
            label="Group Avatar"
            @update:file="handleAvatarChange"
          />

          <FormInput
            id="name"
            v-model="form.name"
            label="Group Name"
            :error="form.errors.name"
            required
          />

          <FormTextarea
            id="description"
            v-model="form.description"
            label="Description"
            :error="form.errors.description"
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

          <DiscordWebhookSection
            v-model="form.discord_webhook_url"
            :error="form.errors.discord_webhook_url"
          />

          <KarmaRequirementSection
            :model-value="form.min_karma"
            :error="form.errors.min_karma"
            @update:model-value="form.min_karma = Number($event)"
          />

          <ClaimCooldownSection
            :model-value="form.claim_cooldown_minutes"
            :error="form.errors.claim_cooldown_minutes"
            @update:model-value="form.claim_cooldown_minutes = $event ? Number($event) : null"
          />

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

      <DangerZone
        v-if="group.can?.delete"
        @delete="deleteGroup"
      />
    </div>
  </AppLayout>
</template>
