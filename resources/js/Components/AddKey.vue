<template>
    <div class="space-y-6">
        <div v-if="dlcEnabled" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Key Type:</label>
                <div class="flex space-x-4">
                    <label class="flex items-center">
                        <input
                            v-model="keyType"
                            type="radio"
                            value="Game"
                            class="mr-2"
                        />
                        <span class="text-gray-300">Game</span>
                    </label>
                    <label class="flex items-center">
                        <input
                            v-model="keyType"
                            type="radio"
                            value="DLC"
                            class="mr-2"
                        />
                        <span class="text-gray-300">DLC</span>
                    </label>
                </div>
            </div>

            <AddKeyGame
                v-if="keyType === 'Game'"
                :platforms="platforms"
            />
            <AddKeyDlc
                v-if="keyType === 'DLC'"
                :platforms="platforms"
            />
        </div>
        <div v-else>
            <AddKeyGame :platforms="platforms" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import AddKeyGame from './AddKeyGame.vue';
import AddKeyDlc from './AddKeyDlc.vue';
import { PlatformData } from '@/Types/generated';

interface Props {
    platforms: PlatformData[];
    dlcEnabled: boolean;
}

const props = defineProps<Props>();

const keyType = ref('Game');
</script>
