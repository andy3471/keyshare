<script setup lang="ts">
import KarmaBadge from './KarmaBadge.vue';

interface Props {
  avatar?: string | null;
  name: string;
  karma?: number;
  karmaColour?: string;
  size?: 'sm' | 'md' | 'lg' | 'xl';
  showKarma?: boolean;
}

withDefaults(defineProps<Props>(), {
  avatar: null,
  karma: 0,
  karmaColour: '',
  size: 'md',
  showKarma: true,
});

const sizeClasses: Record<string, string> = {
  sm: 'w-5 h-5',
  md: 'w-10 h-10 border-2 border-dark-600',
  lg: 'w-24 h-24 border-2 border-dark-600',
  xl: 'w-32 h-32 border-4 border-dark-600 shadow-xl',
};

const badgePositionClasses: Record<string, string> = {
  sm: '-bottom-0.5 -right-0.5',
  md: '-bottom-1 -right-1',
  lg: '-bottom-2 -right-2',
  xl: '-bottom-2 -right-2',
};

const badgeSizeMap: Record<string, 'sm' | 'md' | 'lg'> = {
  sm: 'sm',
  md: 'sm',
  lg: 'md',
  xl: 'lg',
};
</script>

<template>
  <div class="relative flex-shrink-0">
    <img
      :src="avatar || '/images/defaultpic.jpg'"
      :alt="name"
      class="rounded-full object-cover"
      :class="sizeClasses[size]"
    >
    <div
      v-if="showKarma && karmaColour"
      class="absolute"
      :class="badgePositionClasses[size]"
    >
      <KarmaBadge
        :karma="karma"
        :karma-colour="karmaColour"
        :size="badgeSizeMap[size]"
      />
    </div>
  </div>
</template>
