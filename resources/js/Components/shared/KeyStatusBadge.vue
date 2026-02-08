<script setup lang="ts">
import { computed } from 'vue';
import type { ClaimDeniedReason } from '@/Types/generated';
import { CheckCircleIcon, XCircleIcon, ClockIcon } from '@heroicons/vue/24/outline';

interface Props {
  canClaim: boolean;
  claimDeniedReason?: ClaimDeniedReason | null;
}

const props = withDefaults(defineProps<Props>(), {
  claimDeniedReason: null,
});

const label = computed(() => {
  if (props.canClaim) return 'Available';

  switch (props.claimDeniedReason) {
    case 'cooldown_active': return 'Cooldown';
    case 'karma_too_low': return 'Karma too low';
    case 'own_key': return 'Your key';
    case 'already_claimed': return 'Claimed';
    default: return 'Unavailable';
  }
});

const isCooldown = computed(() => props.claimDeniedReason === 'cooldown_active');
</script>

<template>
  <div
    class="flex items-center gap-1 text-xs font-medium"
    :class="canClaim ? 'text-success' : isCooldown ? 'text-primary-400' : 'text-gray-500'"
  >
    <CheckCircleIcon
      v-if="canClaim"
      class="w-4 h-4"
    />
    <ClockIcon
      v-else-if="isCooldown"
      class="w-4 h-4"
    />
    <XCircleIcon
      v-else
      class="w-4 h-4"
    />
    <span>{{ label }}</span>
  </div>
</template>
