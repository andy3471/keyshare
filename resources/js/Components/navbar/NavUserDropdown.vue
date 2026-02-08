<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import AppMenu from '@/Components/ui/AppMenu.vue';
import AppMenuItem from '@/Components/ui/AppMenuItem.vue';
import UserAvatar from '@/Components/shared/UserAvatar.vue';
import { logout as logoutRoute } from '@/routes';
import keys from '@/routes/keys';
import users from '@/routes/users';
import { UserData } from '@/Types/generated';
import { ChevronDownIcon } from '@heroicons/vue/20/solid';

interface Props {
  user: UserData;
}

defineProps<Props>();

const logout = () => {
  const form = useForm({});
  form.post(logoutRoute.url());
};
</script>

<template>
  <AppMenu>
    <template #trigger>
      <button class="flex items-center gap-2 text-gray-300 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-dark-800">
        <UserAvatar
          :avatar="user.avatar"
          :name="user.name"
          :karma="user.karma"
          :karma-colour="user.karma_colour"
          size="md"
          tooltip-position="below"
        />
        <span class="hidden xl:inline truncate max-w-[10rem]">{{ user.name }}</span>
        <ChevronDownIcon class="h-4 w-4" />
      </button>
    </template>

    <AppMenuItem as="a">
      <Link
        :href="users.show.url(user.id)"
        class="block"
      >
        View Profile
      </Link>
    </AppMenuItem>
    <AppMenuItem as="a">
      <Link
        :href="users.edit.url(user.id)"
        class="block"
      >
        Update Profile
      </Link>
    </AppMenuItem>
    <AppMenuItem
      v-if="user.is_admin"
      as="a"
    >
      <Link
        href="/admin"
        class="block"
      >
        Admin
      </Link>
    </AppMenuItem>

    <div class="border-t border-dark-700 my-1" />

    <AppMenuItem as="a">
      <Link
        :href="keys.claimed.index.url()"
        class="block"
      >
        Claimed Keys
      </Link>
    </AppMenuItem>
    <AppMenuItem as="a">
      <Link
        :href="keys.shared.index.url()"
        class="block"
      >
        Shared Keys
      </Link>
    </AppMenuItem>

    <div class="border-t border-dark-700 my-1" />

    <AppMenuItem>
      <button
        class="w-full text-left text-gray-300 hover:text-white"
        @click="logout"
      >
        Logout
      </button>
    </AppMenuItem>
  </AppMenu>
</template>
