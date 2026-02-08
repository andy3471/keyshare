<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import GroupAvatar from '@/Components/shared/GroupAvatar.vue';
import groups from '@/routes/groups';
import { GroupData } from '@/Types/generated';
import { ChevronDownIcon, CheckIcon, GlobeAltIcon, UsersIcon } from '@heroicons/vue/20/solid';

const page = usePage();

const userGroups = computed((): GroupData[] => {
  const g = page.props.userGroups as GroupData[] | undefined;
  return g ?? [];
});

const activeGroup = computed(() => page.props.activeGroup as GroupData | null);

const switchToGroup = (groupId: string | null) => {
  router.post(groups.switch.url(), { group_id: groupId }, {
    preserveState: false,
  });
};
</script>

<template>
  <Menu
    as="div"
    class="relative"
  >
    <MenuButton
      class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200"
      :class="activeGroup
        ? 'bg-accent-600/20 text-accent-400 hover:bg-accent-600/30 border border-accent-600/30'
        : 'text-gray-400 hover:text-white hover:bg-dark-800 border border-dark-700'"
    >
      <GroupAvatar
        v-if="activeGroup"
        :avatar="activeGroup.avatar"
        :name="activeGroup.name"
        size="xs"
      />
      <UsersIcon
        v-else
        class="w-4 h-4"
      />
      <span class="max-w-[120px] truncate">
        {{ activeGroup ? activeGroup.name : 'All Groups' }}
      </span>
      <ChevronDownIcon class="w-3 h-3" />
    </MenuButton>

    <transition
      enter-active-class="transition ease-out duration-100"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <MenuItems class="absolute right-0 mt-2 w-56 bg-dark-800 rounded-lg shadow-xl border border-dark-700 overflow-hidden z-50 focus:outline-none">
        <div class="py-1">
          <MenuItem v-slot="{ active }">
            <button
              class="w-full text-left px-4 py-2 text-sm transition-colors flex items-center gap-2"
              :class="[
                !activeGroup ? 'text-accent-400 bg-dark-700' : '',
                active && activeGroup ? 'bg-accent-600 text-white' : '',
                !active && activeGroup ? 'text-gray-300' : '',
              ]"
              @click="switchToGroup(null)"
            >
              <GlobeAltIcon class="w-4 h-4" />
              All Groups
              <CheckIcon
                v-if="!activeGroup"
                class="w-4 h-4 ml-auto text-accent-400"
              />
            </button>
          </MenuItem>

          <div
            v-if="userGroups.length > 0"
            class="border-t border-dark-700 my-1"
          />

          <MenuItem
            v-for="group in userGroups"
            :key="group.id"
            v-slot="{ active }"
          >
            <button
              class="w-full text-left px-4 py-2 text-sm transition-colors flex items-center gap-2"
              :class="[
                activeGroup?.id === group.id ? 'text-accent-400 bg-dark-700' : '',
                active && activeGroup?.id !== group.id ? 'bg-accent-600 text-white' : '',
                !active && activeGroup?.id !== group.id ? 'text-gray-300' : '',
              ]"
              @click="switchToGroup(group.id)"
            >
              <GroupAvatar
                :avatar="group.avatar"
                :name="group.name"
                size="xs"
              />
              <span class="truncate flex-1">{{ group.name }}</span>
              <CheckIcon
                v-if="activeGroup?.id === group.id"
                class="w-4 h-4 text-accent-400"
              />
            </button>
          </MenuItem>

          <div class="border-t border-dark-700 my-1" />

          <MenuItem v-slot="{ active }">
            <a
              :href="groups.index.url()"
              class="block px-4 py-2 text-sm transition-colors"
              :class="active ? 'bg-accent-600 text-white' : 'text-gray-400 hover:text-white'"
            >
              Manage Groups...
            </a>
          </MenuItem>
        </div>
      </MenuItems>
    </transition>
  </Menu>
</template>
