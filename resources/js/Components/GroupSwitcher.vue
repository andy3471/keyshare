<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';
import groups from '@/routes/groups';
import { GroupData } from '@/Types/generated';

const page = usePage();

const userGroups = computed((): GroupData[] => {
  const groups = page.props.userGroups as GroupData[] | undefined;
  return groups ?? [];
});
const activeGroup = computed(() => page.props.activeGroup as GroupData | null);
const isOpen = ref(false);
const containerRef = ref<HTMLElement | null>(null);

const switchToGroup = (groupId: string | null) => {
  router.post(groups.switch.url(), { group_id: groupId }, {
    preserveState: false,
    onFinish: () => {
      isOpen.value = false;
    },
  });
};

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
};

const handleClickOutside = (event: MouseEvent) => {
  if (containerRef.value && !containerRef.value.contains(event.target as Node)) {
    isOpen.value = false;
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
  <div
    ref="containerRef"
    class="relative"
  >
    <button
      class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium rounded-lg transition-all duration-200"
      :class="activeGroup
        ? 'bg-accent-600/20 text-accent-400 hover:bg-accent-600/30 border border-accent-600/30'
        : 'text-gray-400 hover:text-white hover:bg-dark-800 border border-dark-700'"
      @click="toggleDropdown"
    >
      <img
        v-if="activeGroup?.avatar"
        :src="activeGroup.avatar"
        :alt="activeGroup.name"
        class="w-5 h-5 rounded object-cover"
      >
      <svg
        v-else
        class="w-4 h-4"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
        />
      </svg>
      <span class="max-w-[120px] truncate">
        {{ activeGroup ? activeGroup.name : 'All Groups' }}
      </span>
      <svg
        class="w-3 h-3 transition-transform"
        :class="isOpen ? 'rotate-180' : ''"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M19 9l-7 7-7-7"
        />
      </svg>
    </button>

    <div
      v-show="isOpen"
      class="absolute right-0 mt-2 w-56 bg-dark-800 rounded-lg shadow-xl border border-dark-700 overflow-hidden z-50"
    >
      <div class="py-1">
        <!-- All groups (no specific group filter) -->
        <button
          class="w-full text-left px-4 py-2 text-sm transition-colors flex items-center gap-2"
          :class="!activeGroup ? 'text-accent-400 bg-dark-700' : 'text-gray-300 hover:bg-accent-600 hover:text-white'"
          @click="switchToGroup(null)"
        >
          <svg
            class="w-4 h-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"
            />
          </svg>
          All Groups
          <span
            v-if="!activeGroup"
            class="ml-auto text-accent-400"
          >
            <svg
              class="w-4 h-4"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                fill-rule="evenodd"
                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                clip-rule="evenodd"
              />
            </svg>
          </span>
        </button>

        <div
          v-if="userGroups.length > 0"
          class="border-t border-dark-700 my-1"
        />

        <!-- Groups List -->
        <button
          v-for="group in userGroups"
          :key="group.id"
          class="w-full text-left px-4 py-2 text-sm transition-colors flex items-center gap-2"
          :class="activeGroup?.id === group.id ? 'text-accent-400 bg-dark-700' : 'text-gray-300 hover:bg-accent-600 hover:text-white'"
          @click="switchToGroup(group.id)"
        >
          <img
            v-if="group.avatar"
            :src="group.avatar"
            :alt="group.name"
            class="w-5 h-5 rounded object-cover flex-shrink-0"
          >
          <span
            v-else
            class="w-5 h-5 rounded bg-accent-600/20 flex items-center justify-center flex-shrink-0"
          >
            <span class="text-accent-400 text-[10px] font-bold">{{ group.name.charAt(0).toUpperCase() }}</span>
          </span>
          <span class="truncate flex-1">{{ group.name }}</span>
          <span
            v-if="activeGroup?.id === group.id"
            class="text-accent-400"
          >
            <svg
              class="w-4 h-4"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                fill-rule="evenodd"
                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                clip-rule="evenodd"
              />
            </svg>
          </span>
        </button>

        <div class="border-t border-dark-700 my-1" />

        <!-- Manage Groups -->
        <a
          :href="groups.index.url()"
          class="block px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-dark-700 transition-colors"
        >
          Manage Groups...
        </a>
      </div>
    </div>
  </div>
</template>
