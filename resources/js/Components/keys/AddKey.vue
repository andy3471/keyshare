<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppCombobox from '@/Components/ui/AppCombobox.vue';
import AppListbox from '@/Components/ui/AppListbox.vue';
import FormInput from '@/Components/ui/FormInput.vue';
import FormTextarea from '@/Components/ui/FormTextarea.vue';
import LoadingSpinner from '@/Components/ui/LoadingSpinner.vue';
import { AutocompleteGameData, GroupData, PlatformData } from '@/Types/generated';
import keys from '@/routes/keys';
import PlatformIcon from '@/Components/shared/PlatformIcon.vue';
import { UsersIcon, KeyIcon, PlusIcon, TicketIcon } from '@heroicons/vue/24/outline';
import type { ComboboxItem } from '@/types/ui';

interface Props {
  platforms: PlatformData[];
  game?: AutocompleteGameData | null;
  groups: GroupData[];
  activeGroupId?: string | null;
}

const props = defineProps<Props>();

const selectedGame = ref<ComboboxItem | null>(props.game ? { id: props.game.id, name: props.game.name } : null);

const form = useForm({
  igdb_id: props.game?.id ?? '',
  platform_id: '',
  key: '',
  message: '',
  group_id: props.activeGroupId ?? '',
});

const groupOptions = props.groups.map(g => ({ id: g.id, name: g.name }));
const platformOptions = props.platforms.map(p => ({ id: p.id, name: p.name, icon: p.icon }));

const submit = () => {
  form.igdb_id = selectedGame.value?.id.toString() ?? '';

  if (!form.group_id) {
    form.setError('group_id', 'Please select a group to share with.');
    return;
  }

  if (!form.platform_id) {
    form.setError('platform_id', 'Please select a platform.');
    return;
  }

  form.post(keys.store.url(), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      selectedGame.value = null;
    },
  });
};

const handleGameSelect = (item: ComboboxItem | null) => {
  selectedGame.value = item;
};
</script>

<template>
  <div class="bg-dark-800 rounded-lg border border-dark-700 p-8">
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-white mb-2">
        Add New Key
      </h1>
      <p class="text-gray-400">
        Share a game key with the community
      </p>
    </div>

    <form
      class="space-y-6"
      @submit.prevent="submit"
    >
      <div
        v-if="Object.keys(form.errors).length > 0"
        class="bg-red-900/50 border border-red-700 rounded-lg p-4"
      >
        <div
          v-for="(error, field) in form.errors"
          :key="field"
          class="text-red-300 text-sm mb-1"
        >
          <strong class="capitalize">{{ String(field).replace('_', ' ') }}:</strong> {{ Array.isArray(error) ? error[0] : error }}
        </div>
      </div>

      <div class="bg-dark-700/50 rounded-lg p-6">
        <h2 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
          <UsersIcon class="w-6 h-6 text-accent-400" />
          Share With Group
        </h2>
        <AppListbox
          v-model="form.group_id"
          :options="groupOptions"
          label="Group"
          placeholder="Select a group"
          :error="form.errors.group_id"
          hint="Choose which group will see this key"
          required
        />
      </div>

      <div class="bg-dark-700/50 rounded-lg p-6">
        <h2 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
          <TicketIcon class="w-6 h-6 text-accent-400" />
          Game Information
        </h2>
        <div class="space-y-4">
          <div>
            <label
              for="igdb_id"
              class="block text-sm font-medium text-gray-300 mb-2"
            >
              Game or DLC <span class="text-red-400">*</span>
            </label>
            <AppCombobox
              id="igdb_id"
              :model-value="selectedGame"
              name="igdb_id"
              placeholder="Search for a game or DLC..."
              url="/autocomplete"
              @update:model-value="handleGameSelect"
            />
            <p class="mt-2 text-xs text-gray-500">
              Start typing to search IGDB for games and DLCs
            </p>
            <p
              v-if="form.errors.igdb_id"
              class="mt-2 text-sm text-red-400"
            >
              {{ form.errors.igdb_id }}
            </p>
          </div>

          <AppListbox
            v-model="form.platform_id"
            :options="platformOptions"
            label="Platform"
            placeholder="Select a platform"
            :error="form.errors.platform_id"
            required
          >
            <template #selected="{ option }">
              <PlatformIcon
                :icon="option.icon ?? 'generic'"
                size="sm"
              />
              {{ option.name }}
            </template>
            <template #option="{ option }">
              <PlatformIcon
                :icon="option.icon ?? 'generic'"
                size="sm"
              />
              {{ option.name }}
            </template>
          </AppListbox>
        </div>
      </div>

      <div class="bg-dark-700/50 rounded-lg p-6">
        <h2 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
          <KeyIcon class="w-6 h-6 text-accent-400" />
          Key Details
        </h2>
        <div class="space-y-4">
          <FormInput
            id="key"
            v-model="form.key"
            label="Key Code"
            placeholder="XXXXX-XXXXX-XXXXX-XXXXX"
            :error="form.errors.key"
            hint="Enter the game key code"
            required
            input-class="font-mono text-lg tracking-wider"
          />
          <FormTextarea
            id="message"
            v-model="form.message"
            label="Message (Optional)"
            placeholder="Add a message for the person who claims this key..."
            :error="form.errors.message"
            hint="Optional message to include with your shared key"
            :rows="4"
          />
        </div>
      </div>

      <div class="flex flex-col sm:flex-row gap-4 pt-4">
        <button
          type="submit"
          class="flex-1 bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
          :disabled="form.processing"
        >
          <span
            v-if="form.processing"
            class="flex items-center justify-center"
          >
            <LoadingSpinner
              size="md"
              class="-ml-1 mr-3"
            />
            Adding Key...
          </span>
          <span
            v-else
            class="flex items-center justify-center"
          >
            <PlusIcon class="w-5 h-5 mr-2" />
            Add Key
          </span>
        </button>
      </div>
    </form>
  </div>
</template>
