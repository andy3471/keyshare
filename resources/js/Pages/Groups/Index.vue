<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { Head, Link, router, usePage, InfiniteScroll } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import MyGroupCard from '@/Components/groups/MyGroupCard.vue';
import PublicGroupCard from '@/Components/groups/PublicGroupCard.vue';
import EmptyState from '@/Components/shared/EmptyState.vue';
import groups from '@/routes/groups';
import { GroupData } from '@/Types/generated';
import type { Paginated } from '@/types/global';
import { PlusIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline';

interface Props {
  myGroups: GroupData[];
  publicGroups: Paginated<GroupData>;
  search?: string;
}

const props = withDefaults(defineProps<Props>(), {
  search: '',
});

const page = usePage();
const activeGroup = computed(() => page.props.activeGroup as GroupData | null);
const searchQuery = ref(props.search);
let debounceTimer: ReturnType<typeof setTimeout>;

watch(searchQuery, (value) => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    router.get(groups.index.url(), { search: value || undefined }, {
      preserveState: true,
      preserveScroll: true,
      replace: true,
    });
  }, 300);
});

const switchToGroup = (groupId: string, event: Event) => {
  event.stopPropagation();
  event.preventDefault();
  router.post(groups.switch.url(), { group_id: groupId }, { preserveState: false });
};
</script>

<template>
  <AppLayout title="Groups">
    <Head title="Groups" />
    <div class="max-w-7xl mx-auto px-4 py-6 space-y-10">
      <section>
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-2xl font-display font-bold text-white">
            My Groups
          </h2>
          <Link
            :href="groups.create.url()"
            class="inline-flex items-center px-4 py-2 bg-accent-600 hover:bg-accent-500 text-white text-sm font-medium rounded-lg transition-colors"
          >
            <PlusIcon class="w-4 h-4 mr-2" />
            Create Group
          </Link>
        </div>

        <EmptyState
          v-if="myGroups.length === 0"
          title="No groups yet"
          message="You haven't joined any groups yet."
        >
          <template #action>
            <Link
              :href="groups.create.url()"
              class="text-accent-400 hover:text-accent-300 font-medium mt-2 inline-block"
            >
              Create your first group
            </Link>
          </template>
        </EmptyState>

        <div
          v-else
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
        >
          <MyGroupCard
            v-for="group in myGroups"
            :key="group.id"
            :group="group"
            :is-active="activeGroup?.id === group.id"
            @switch-to="switchToGroup"
          />
        </div>
      </section>

      <section>
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
          <h2 class="text-2xl font-display font-bold text-white">
            Discover Public Groups
          </h2>
          <div class="relative w-full sm:w-72">
            <MagnifyingGlassIcon class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 pointer-events-none" />
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search groups..."
              class="w-full pl-10 pr-4 py-2 bg-dark-800 border border-dark-600 text-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 placeholder-gray-500"
            >
          </div>
        </div>

        <InfiniteScroll
          v-if="publicGroups.data.length > 0"
          data="publicGroups"
          preserve-url
        >
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <PublicGroupCard
              v-for="group in publicGroups.data"
              :key="group.id"
              :group="group"
            />
          </div>
        </InfiniteScroll>

        <EmptyState
          v-else
          :title="searchQuery ? `No groups found matching &quot;${searchQuery}&quot;` : 'No public groups available'"
          :message="searchQuery ? '' : 'No public groups available to join right now'"
        >
          <template #icon>
            <MagnifyingGlassIcon class="w-12 h-12 text-dark-500" />
          </template>
        </EmptyState>
      </section>
    </div>
  </AppLayout>
</template>
