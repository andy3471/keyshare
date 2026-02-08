<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ConfirmModal from '@/Components/ConfirmModal.vue';
import groups from '@/routes/groups';
import { GroupData, GroupMemberData } from '@/Types/generated';

interface Props {
  group: GroupData;
  members: GroupMemberData[];
  isMember: boolean;
}

const props = defineProps<Props>();

const page = usePage();
const activeGroup = page.props.activeGroup as GroupData | null;

const isActive = computed(() => activeGroup?.id === props.group.id);

const showInviteCode = ref(false);
const inviteUrl = computed(() => {
  if (!props.group.invite_code) {
    return '';
  }
  return `${window.location.origin}/invite/${props.group.invite_code}`;
});

const copyInviteLink = () => {
  void navigator.clipboard.writeText(inviteUrl.value);
};

const joinGroup = () => {
  router.post(groups.join.url(props.group.id));
};

// Confirm modal state
const showLeaveModal = ref(false);
const showRemoveMemberModal = ref(false);
const showRegenerateModal = ref(false);
const memberToRemove = ref<string | null>(null);

const leaveGroup = () => {
  showLeaveModal.value = false;
  router.post(groups.leave.url(props.group.id));
};

const switchToGroup = () => {
  router.post(groups.switch.url(), { group_id: props.group.id });
};

const confirmRemoveMember = (memberId: string) => {
  memberToRemove.value = memberId;
  showRemoveMemberModal.value = true;
};

const removeMember = () => {
  if (memberToRemove.value) {
    showRemoveMemberModal.value = false;
    router.delete(groups.members.remove.url({ group: props.group.id, user: memberToRemove.value }));
    memberToRemove.value = null;
  }
};

const regenerateCode = () => {
  showRegenerateModal.value = false;
  router.post(groups.regenerateInviteCode.url(props.group.id));
};
</script>

<template>
  <AppLayout :title="group.name">
    <Head :title="group.name" />
    <div class="max-w-5xl mx-auto px-4 py-6 space-y-6">
      <!-- Group Header -->
      <div class="bg-dark-800 rounded-xl p-6 border border-dark-700">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
          <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
              <img
                v-if="group.avatar"
                :src="group.avatar"
                :alt="group.name"
                class="w-16 h-16 rounded-xl object-cover border-2 border-dark-600"
              >
              <div
                v-else
                class="w-16 h-16 rounded-xl bg-accent-600/20 border-2 border-dark-600 flex items-center justify-center"
              >
                <span class="text-accent-400 font-bold text-2xl">{{ group.name.charAt(0).toUpperCase() }}</span>
              </div>
            </div>
            <div>
              <div class="flex items-center gap-3 mb-2">
                <h1 class="text-2xl font-display font-bold text-white">
                  {{ group.name }}
                </h1>
                <span
                  v-if="group.is_public"
                  class="text-xs px-2 py-0.5 rounded-full bg-green-600/20 text-green-400 font-medium"
                >
                  Public
                </span>
                <span
                  v-else
                  class="text-xs px-2 py-0.5 rounded-full bg-dark-600 text-gray-400 font-medium"
                >
                  Private
                </span>
              </div>
              <p
                v-if="group.description"
                class="text-gray-400 max-w-xl"
              >
                {{ group.description }}
              </p>
              <div class="flex items-center gap-4 mt-3 text-sm text-gray-500">
                <span>{{ group.member_count }} {{ group.member_count === 1 ? 'member' : 'members' }}</span>
              </div>
            </div>
          </div>

          <div class="flex flex-wrap gap-2">
            <template v-if="isMember">
              <button
                v-if="!isActive"
                class="px-4 py-2 bg-accent-600 hover:bg-accent-500 text-white text-sm font-medium rounded-lg transition-colors"
                @click="switchToGroup"
              >
                Switch to Group
              </button>
              <span
                v-else
                class="px-4 py-2 bg-accent-600/20 text-accent-400 text-sm font-medium rounded-lg"
              >
                Active Group
              </span>

              <Link
                v-if="group.can?.update"
                :href="groups.edit.url(group.id)"
                class="px-4 py-2 bg-dark-700 hover:bg-dark-600 text-gray-300 text-sm font-medium rounded-lg transition-colors"
              >
                Settings
              </Link>

              <button
                v-if="group.can?.leave"
                class="px-4 py-2 bg-dark-700 hover:bg-danger-600 text-gray-300 hover:text-white text-sm font-medium rounded-lg transition-colors"
                @click="showLeaveModal = true"
              >
                Leave
              </button>
            </template>

            <template v-else-if="group.is_public">
              <button
                class="px-4 py-2 bg-accent-600 hover:bg-accent-500 text-white text-sm font-medium rounded-lg transition-colors"
                @click="joinGroup"
              >
                Join Group
              </button>
            </template>
          </div>
        </div>
      </div>

      <!-- Invite Link Section -->
      <div
        v-if="group.can?.invite"
        class="bg-dark-800 rounded-xl p-6 border border-dark-700"
      >
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-lg font-semibold text-white">
            Invite Link
          </h2>
          <button
            class="text-sm text-gray-400 hover:text-white transition-colors"
            @click="showInviteCode = !showInviteCode"
          >
            {{ showInviteCode ? 'Hide' : 'Show' }}
          </button>
        </div>
        <div v-if="showInviteCode">
          <div class="flex items-center gap-2">
            <input
              type="text"
              :value="inviteUrl"
              readonly
              class="flex-1 bg-dark-900 border border-dark-600 rounded-lg px-4 py-2.5 text-gray-300 text-sm font-mono"
            >
            <button
              class="px-4 py-2.5 bg-accent-600 hover:bg-accent-500 text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap"
              @click="copyInviteLink"
            >
              Copy
            </button>
            <button
              class="px-4 py-2.5 bg-dark-700 hover:bg-dark-600 text-gray-300 text-sm font-medium rounded-lg transition-colors whitespace-nowrap"
              @click="showRegenerateModal = true"
            >
              Regenerate
            </button>
          </div>
          <p class="text-xs text-gray-500 mt-2">
            Share this link with anyone you want to invite to the group.
          </p>
        </div>
      </div>

      <!-- Members -->
      <div class="bg-dark-800 rounded-xl p-6 border border-dark-700">
        <h2 class="text-lg font-semibold text-white mb-4">
          Members
        </h2>
        <div class="space-y-3">
          <div
            v-for="member in members"
            :key="member.id"
            class="flex items-center justify-between p-3 bg-dark-900 rounded-lg"
          >
            <div class="flex items-center gap-3">
              <img
                :src="member.avatar || '/images/defaultpic.jpg'"
                :alt="member.name"
                class="w-10 h-10 rounded-full object-cover"
              >
              <div>
                <p class="text-white font-medium text-sm">
                  {{ member.name }}
                </p>
                <span
                  class="text-xs font-medium"
                  :class="{
                    'text-accent-400': member.role === 'owner',
                    'text-primary-400': member.role === 'admin',
                    'text-gray-500': member.role === 'member',
                  }"
                >
                  {{ member.role }}
                </span>
              </div>
            </div>
            <button
              v-if="group.can?.manageMembers && member.role !== 'owner'"
              class="text-xs text-gray-500 hover:text-danger-400 transition-colors"
              @click="confirmRemoveMember(member.id)"
            >
              Remove
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Leave Group Modal -->
    <ConfirmModal
      :open="showLeaveModal"
      title="Leave group"
      message="Are you sure you want to leave this group? You'll lose access to all keys shared within it."
      confirm-label="Leave group"
      variant="danger"
      @confirm="leaveGroup"
      @cancel="showLeaveModal = false"
    />

    <!-- Remove Member Modal -->
    <ConfirmModal
      :open="showRemoveMemberModal"
      title="Remove member"
      message="Are you sure you want to remove this member from the group?"
      confirm-label="Remove"
      variant="danger"
      @confirm="removeMember"
      @cancel="showRemoveMemberModal = false"
    />

    <!-- Regenerate Invite Code Modal -->
    <ConfirmModal
      :open="showRegenerateModal"
      title="Regenerate invite link"
      message="This will invalidate the existing invite link. Anyone with the old link will no longer be able to join."
      confirm-label="Regenerate"
      variant="warning"
      @confirm="regenerateCode"
      @cancel="showRegenerateModal = false"
    />
  </AppLayout>
</template>
