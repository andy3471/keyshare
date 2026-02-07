<template>
    <form @submit.prevent="submit" class="space-y-4">
        <div>
            <label for="gamename" class="block text-sm font-medium text-gray-300 mb-2">
                Game:
            </label>
            <Autocomplete
                id="gamename"
                v-model="form.gamename"
                name="gamename"
                placeholder="Search for a game..."
                url="/autocomplete/games"
                @select="handleGameSelect"
            />
            <div v-if="form.errors.gamename" class="mt-1 text-sm text-danger">
                {{ form.errors.gamename }}
            </div>
        </div>

        <div>
            <label for="dlcname" class="block text-sm font-medium text-gray-300 mb-2">
                DLC:
            </label>
            <Autocomplete
                id="dlcname"
                v-model="form.dlcname"
                name="dlcname"
                placeholder="Search for DLC..."
                :url="`/autocomplete/dlc/${form.gamename}`"
            />
            <div v-if="form.errors.dlcname" class="mt-1 text-sm text-danger">
                {{ form.errors.dlcname }}
            </div>
        </div>

        <div>
            <label for="platform" class="block text-sm font-medium text-gray-300 mb-2">
                Platform:
            </label>
            <select
                id="platform"
                v-model="form.platform_id"
                name="platform_id"
                class="form-control w-full"
            >
                <option value="">Select a platform</option>
                <option
                    v-for="platform in platforms"
                    :key="platform.id"
                    :value="platform.id"
                >
                    {{ platform.name }}
                </option>
            </select>
            <div v-if="form.errors.platform_id" class="mt-1 text-sm text-danger">
                {{ form.errors.platform_id }}
            </div>
        </div>

        <div>
            <label for="key" class="block text-sm font-medium text-gray-300 mb-2">
                Key:
            </label>
            <input
                id="key"
                v-model="form.key"
                name="key"
                type="text"
                required
                class="form-control w-full"
            />
            <div v-if="form.errors.key" class="mt-1 text-sm text-danger">
                {{ form.errors.key }}
            </div>
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-gray-300 mb-2">
                Message (optional):
            </label>
            <textarea
                id="message"
                v-model="form.message"
                name="message"
                rows="3"
                class="form-control w-full"
            />
            <div v-if="form.errors.message" class="mt-1 text-sm text-danger">
                {{ form.errors.message }}
            </div>
        </div>

        <input type="hidden" name="key_type" value="2" />

        <button
            type="submit"
            class="btn-accent"
            :disabled="form.processing"
        >
            <span v-if="form.processing">Adding...</span>
            <span v-else>Add Key</span>
        </button>
    </form>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import Autocomplete from './Autocomplete.vue';
import { PlatformData } from '@/Types/generated';
import keys from '@/routes/keys';

interface Props {
    platforms: PlatformData[];
}

defineProps<Props>();

const form = useForm({
    gamename: '',
    dlcname: '',
    platform_id: '',
    key: '',
    message: '',
    key_type: '2',
});

const handleGameSelect = (item: any) => {
    form.gamename = item.name || item;
};

const submit = () => {
    form.post(keys.store.url(), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>
