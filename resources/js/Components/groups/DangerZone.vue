<script setup lang="ts">
import { ref } from 'vue';
import ConfirmModal from '@/Components/ui/ConfirmModal.vue';

const emit = defineEmits<{
  delete: [];
}>();

const showDeleteModal = ref(false);

const confirmDelete = () => {
  showDeleteModal.value = false;
  emit('delete');
};
</script>

<template>
  <div class="bg-dark-800 rounded-xl p-6 border border-danger-600/30">
    <h2 class="text-lg font-semibold text-danger-400 mb-2">
      Danger Zone
    </h2>
    <p class="text-gray-400 text-sm mb-4">
      Deleting the group will permanently remove all data associated with it. Keys shared within this group will become ungrouped.
    </p>
    <button
      class="px-4 py-2 bg-danger-600 hover:bg-danger-500 text-white text-sm font-medium rounded-lg transition-colors"
      @click="showDeleteModal = true"
    >
      Delete Group
    </button>

    <ConfirmModal
      :open="showDeleteModal"
      title="Delete group"
      message="Are you sure you want to permanently delete this group? All keys and members will be removed. This action cannot be undone."
      confirm-label="Delete group"
      variant="danger"
      @confirm="confirmDelete"
      @cancel="showDeleteModal = false"
    />
  </div>
</template>
