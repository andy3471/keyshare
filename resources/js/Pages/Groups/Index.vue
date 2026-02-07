<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import groups from '@/routes/groups';
import { GroupData } from '@/Types/generated';
import { computed } from 'vue';

interface Props {
  myGroups: GroupData[];
  publicGroups: GroupData[];
}

defineProps<Props>();

const page = usePage();
const activeGroup = computed(() => page.props.activeGroup as GroupData | null);

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
      <!-- My Groups -->
      <section>
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-2xl font-display font-bold text-white">
            My Groups
          </h2>
          <Link
            :href="groups.create.url()"
            class="inline-flex items-center px-4 py-2 bg-accent-600 hover:bg-accent-500 text-white text-sm font-medium rounded-lg transition-colors"
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
                d="M12 4v16m8-8H4"
              />
            </svg>
            Create Group
          </Link>
        </div>

        <div
          v-if="myGroups.length === 0"
          class="bg-dark-800 rounded-xl p-8 text-center border border-dark-700"
        >
          <p class="text-gray-400 mb-4">
            You haven't joined any groups yet.
          </p>
          <Link
            :href="groups.create.url()"
            class="text-accent-400 hover:text-accent-300 font-medium"
          >
            Create your first group
          </Link>
        </div>

        <div
          v-else
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
        >
          <Link
            v-for="group in myGroups"
            :key="group.id"
            :href="groups.show.url(group.id)"
            class="bg-dark-800 rounded-xl p-5 border-2 transition-all group relative"
            :class="activeGroup?.id === group.id
              ? 'border-accent-500 shadow-lg shadow-accent-500/10'
              : 'border-dark-700 hover:border-dark-500'"
          >
            <!-- Active indicator -->
            <div
              v-if="activeGroup?.id === group.id"
              class="absolute top-3 right-3"
            >
              <span class="inline-flex items-center gap-1 text-xs px-2 py-1 rounded-full bg-accent-600/20 text-accent-400 font-medium">
                <span class="w-1.5 h-1.5 rounded-full bg-accent-400 animate-pulse" />
                Active
              </span>
            </div>

            <div class="flex items-start gap-3 mb-3 pr-16">
              <div class="flex-shrink-0">
                <img
                  v-if="group.avatar"
                  :src="group.avatar"
                  :alt="group.name"
                  class="w-10 h-10 rounded-lg object-cover"
                >
                <div
                  v-else
                  class="w-10 h-10 rounded-lg bg-accent-600/20 flex items-center justify-center"
                >
                  <span class="text-accent-400 font-bold text-sm">{{ group.name.charAt(0).toUpperCase() }}</span>
                </div>
              </div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                  <h3
                    class="text-lg font-semibold transition-colors truncate"
                    :class="activeGroup?.id === group.id ? 'text-accent-400' : 'text-white group-hover:text-accent-400'"
                  >
                    {{ group.name }}
                  </h3>
                  <span
                    v-if="group.role"
                    class="text-xs px-2 py-1 rounded-full font-medium flex-shrink-0"
                    :class="{
                      'bg-accent-600/20 text-accent-400': group.role === 'owner',
                      'bg-primary-600/20 text-primary-400': group.role === 'admin',
                      'bg-dark-600 text-gray-400': group.role === 'member',
                    }"
                  >
                    {{ group.role }}
                  </span>
                </div>
              </div>
            </div>
            <p
              v-if="group.description"
              class="text-gray-400 text-sm mb-3 line-clamp-2"
            >
              {{ group.description }}
            </p>
            <div class="flex items-center justify-between mt-auto">
              <div class="flex items-center gap-3 text-xs text-gray-500">
                <span class="flex items-center gap-1">
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
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                  </svg>
                  {{ group.member_count }} {{ group.member_count === 1 ? 'member' : 'members' }}
                </span>
                <span
                  v-if="group.is_public"
                  class="flex items-center gap-1 text-green-400"
                >
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
                      d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"
                    />
                  </svg>
                  Public
                </span>
                <span
                  v-else
                  class="flex items-center gap-1"
                >
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
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                    />
                  </svg>
                  Private
                </span>
              </div>
              <button
                v-if="activeGroup?.id !== group.id"
                class="text-xs px-3 py-1.5 rounded-lg bg-dark-700 hover:bg-accent-600 text-gray-400 hover:text-white font-medium transition-colors"
                @click="switchToGroup(group.id, $event)"
              >
                Set Active
              </button>
            </div>
          </Link>
        </div>
      </section>

      <!-- Public Groups -->
      <section v-if="publicGroups.length > 0">
        <h2 class="text-2xl font-display font-bold text-white mb-6">
          Discover Public Groups
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <div
            v-for="group in publicGroups"
            :key="group.id"
            class="bg-dark-800 rounded-xl p-5 border border-dark-700 hover:border-accent-600/50 transition-all"
          >
            <div class="flex items-start justify-between mb-3">
              <Link
                :href="groups.show.url(group.id)"
                class="text-lg font-semibold text-white hover:text-accent-400 transition-colors"
              >
                {{ group.name }}
              </Link>
            </div>
            <p
              v-if="group.description"
              class="text-gray-400 text-sm mb-4 line-clamp-2"
            >
              {{ group.description }}
            </p>
            <div class="flex items-center justify-between">
              <span class="text-xs text-gray-500 flex items-center gap-1">
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
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                </svg>
                {{ group.member_count }} {{ group.member_count === 1 ? 'member' : 'members' }}
              </span>
              <Link
                :href="groups.show.url(group.id)"
                class="text-sm text-accent-400 hover:text-accent-300 font-medium"
              >
                View Group
              </Link>
            </div>
          </div>
        </div>
      </section>
    </div>
  </AppLayout>
</template>
