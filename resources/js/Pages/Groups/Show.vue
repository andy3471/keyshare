<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ConfirmModal from '@/Components/ui/ConfirmModal.vue';
import GroupAvatar from '@/Components/shared/GroupAvatar.vue';
import UserAvatar from '@/Components/shared/UserAvatar.vue';
import groups from '@/routes/groups';
import users from '@/routes/users';
import { GroupData, GroupMemberData } from '@/Types/generated';
import {
  Cog6ToothIcon,
  ArrowRightStartOnRectangleIcon,
  ClipboardDocumentIcon,
  ArrowPathIcon,
  UserGroupIcon,
  LinkIcon,
  EyeIcon,
  EyeSlashIcon,
  UserMinusIcon,
  ArrowsRightLeftIcon,
  CheckIcon,
} from '@heroicons/vue/24/outline';

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
  if (!props.group.invite_code) return '';
  return `${window.location.origin}/invite/${props.group.invite_code}`;
});

const copied = ref(false);
const copyInviteLink = () => {
  void navigator.clipboard.writeText(inviteUrl.value);
  copied.value = true;
  setTimeout(() => { copied.value = false; }, 2000);
};

const joinGroup = () => {
  router.post(groups.join.url(props.group.id));
};

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

const roleBadgeClasses: Record<string, string> = {
  owner: 'bg-accent-600/20 text-accent-400',
  admin: 'bg-primary-600/20 text-primary-400',
  member: 'bg-dark-600 text-gray-400',
};
</script>

<template>
  <AppLayout :title="group.name">
    <Head :title="group.name" />
    <div class="max-w-7xl mx-auto px-4 py-6">
      <div class="bg-gradient-to-r from-dark-800 via-dark-700 to-dark-800 rounded-lg border border-dark-700 p-8 mb-6 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
          <div
            class="absolute inset-0"
            style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(139, 92, 246, 0.1) 10px, rgba(139, 92, 246, 0.1) 20px);"
          />
        </div>

        <div class="relative flex flex-col md:flex-row items-start md:items-center gap-6">
          <GroupAvatar
            :avatar="group.avatar"
            :name="group.name"
            size="xl"
            class="border-4 border-dark-600 shadow-xl"
          />

          <div class="flex-1">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
              <div>
                <div class="flex items-center gap-3 mb-2">
                  <h1 class="text-4xl font-bold text-white">
                    {{ group.name }}
                  </h1>
                  <span
                    v-if="group.is_public"
                    class="text-xs px-2.5 py-1 rounded-full bg-green-600/20 text-green-400 font-medium"
                  >
                    Public
                  </span>
                  <span
                    v-else
                    class="text-xs px-2.5 py-1 rounded-full bg-yellow-600/20 text-yellow-400 font-medium"
                  >
                    Private
                  </span>
                </div>
                <p
                  v-if="group.description"
                  class="text-gray-300 text-lg leading-relaxed max-w-2xl mb-3"
                >
                  {{ group.description }}
                </p>
                <div class="flex items-center gap-2 text-sm text-gray-400">
                  <UserGroupIcon class="w-4 h-4" />
                  <span>{{ group.member_count }} {{ group.member_count === 1 ? 'member' : 'members' }}</span>
                </div>
              </div>

              <div class="flex flex-wrap gap-2">
                <template v-if="isMember">
                  <button
                    v-if="!isActive"
                    class="bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5 active:translate-y-0 inline-flex items-center whitespace-nowrap"
                    @click="switchToGroup"
                  >
                    <ArrowsRightLeftIcon class="w-5 h-5 mr-2" />
                    Switch to Group
                  </button>
                  <span
                    v-else
                    class="inline-flex items-center py-3 px-6 bg-accent-600/20 text-accent-400 font-semibold rounded-lg whitespace-nowrap"
                  >
                    <CheckIcon class="w-5 h-5 mr-2" />
                    Active Group
                  </span>

                  <Link
                    v-if="group.can?.update"
                    :href="groups.edit.url(group.id)"
                    class="inline-flex items-center py-3 px-5 bg-dark-600 hover:bg-dark-500 text-gray-300 hover:text-white font-medium rounded-lg transition-all duration-200 whitespace-nowrap"
                  >
                    <Cog6ToothIcon class="w-5 h-5 mr-2" />
                    Settings
                  </Link>

                  <button
                    v-if="group.can?.leave"
                    class="inline-flex items-center py-3 px-5 bg-dark-600 hover:bg-danger text-gray-300 hover:text-white font-medium rounded-lg transition-all duration-200 whitespace-nowrap"
                    @click="showLeaveModal = true"
                  >
                    <ArrowRightStartOnRectangleIcon class="w-5 h-5 mr-2" />
                    Leave
                  </button>
                </template>

                <template v-else-if="group.is_public">
                  <button
                    class="bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg shadow-accent-600/20 hover:shadow-xl hover:shadow-accent-600/30 hover:-translate-y-0.5 active:translate-y-0 inline-flex items-center whitespace-nowrap"
                    @click="joinGroup"
                  >
                    <UserGroupIcon class="w-5 h-5 mr-2" />
                    Join Group
                  </button>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div
        v-if="group.can?.invite"
        class="bg-dark-800 rounded-lg border border-dark-700 p-6 mb-6"
      >
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <LinkIcon class="w-5 h-5 text-accent-400" />
            Invite Link
          </h2>
          <button
            class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-white transition-colors"
            @click="showInviteCode = !showInviteCode"
          >
            <EyeSlashIcon
              v-if="showInviteCode"
              class="w-4 h-4"
            />
            <EyeIcon
              v-else
              class="w-4 h-4"
            />
            {{ showInviteCode ? 'Hide' : 'Show' }}
          </button>
        </div>
        <div v-if="showInviteCode">
          <div class="flex items-center gap-2">
            <input
              type="text"
              :value="inviteUrl"
              readonly
              class="flex-1 bg-dark-900 border border-dark-600 rounded-lg px-4 py-2.5 text-gray-300 text-sm font-mono focus:outline-none"
            >
            <button
              class="inline-flex items-center gap-2 px-4 py-2.5 bg-accent-600 hover:bg-accent-500 text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap"
              @click="copyInviteLink"
            >
              <ClipboardDocumentIcon class="w-4 h-4" />
              {{ copied ? 'Copied!' : 'Copy' }}
            </button>
            <button
              class="inline-flex items-center gap-2 px-4 py-2.5 bg-dark-700 hover:bg-dark-600 text-gray-300 text-sm font-medium rounded-lg transition-colors whitespace-nowrap"
              @click="showRegenerateModal = true"
            >
              <ArrowPathIcon class="w-4 h-4" />
              Regenerate
            </button>
          </div>
          <p class="text-xs text-gray-500 mt-2">
            Share this link with anyone you want to invite to the group.
          </p>
        </div>
      </div>

      <div class="bg-dark-800 rounded-lg border border-dark-700 p-6">
        <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
          <UserGroupIcon class="w-5 h-5 text-accent-400" />
          Members
          <span class="text-sm font-normal text-gray-500">
            ({{ members.length }})
          </span>
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
          <div
            v-for="member in members"
            :key="member.id"
            class="flex items-center justify-between p-3 rounded-lg border border-dark-600 hover:border-dark-500 hover:bg-dark-700/50 transition-all duration-200"
          >
            <Link
              :href="users.show.url(member.id)"
              class="flex items-center gap-3 flex-1 min-w-0"
            >
              <UserAvatar
                :avatar="member.avatar"
                :name="member.name"
                size="md"
                :show-karma="false"
              />
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate hover:text-accent-400 transition-colors">
                  {{ member.name }}
                </p>
                <span
                  class="inline-block text-xs font-medium px-2 py-0.5 rounded-full mt-0.5"
                  :class="roleBadgeClasses[member.role] ?? roleBadgeClasses.member"
                >
                  {{ member.role }}
                </span>
              </div>
            </Link>
            <button
              v-if="group.can?.manageMembers && member.role !== 'owner'"
              class="flex-shrink-0 ml-2 p-1.5 text-gray-500 hover:text-danger hover:bg-danger/10 rounded-lg transition-colors"
              title="Remove member"
              @click="confirmRemoveMember(member.id)"
            >
              <UserMinusIcon class="w-4 h-4" />
            </button>
          </div>
        </div>
      </div>
    </div>

    <ConfirmModal
      :open="showLeaveModal"
      title="Leave group"
      message="Are you sure you want to leave this group? You'll lose access to all keys shared within it."
      confirm-label="Leave group"
      variant="danger"
      @confirm="leaveGroup"
      @cancel="showLeaveModal = false"
    />

    <ConfirmModal
      :open="showRemoveMemberModal"
      title="Remove member"
      message="Are you sure you want to remove this member from the group?"
      confirm-label="Remove"
      variant="danger"
      @confirm="removeMember"
      @cancel="showRemoveMemberModal = false"
    />

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
