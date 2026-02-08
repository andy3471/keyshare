import { ref, computed, onMounted, onUnmounted } from 'vue';

export function useCountdown(endsAt: string | null) {
  const now = ref(Date.now());
  let timer: ReturnType<typeof setInterval> | null = null;

  const targetTime = endsAt ? new Date(endsAt).getTime() : 0;

  const remainingMs = computed(() => {
    if (!endsAt) return 0;
    return Math.max(0, targetTime - now.value);
  });

  const isExpired = computed(() => remainingMs.value <= 0);

  const formatted = computed(() => {
    const total = remainingMs.value;
    if (total <= 0) return '0s';

    const hours = Math.floor(total / 3_600_000);
    const minutes = Math.floor((total % 3_600_000) / 60_000);
    const seconds = Math.floor((total % 60_000) / 1_000);

    const parts: string[] = [];
    if (hours > 0) parts.push(`${String(hours)}h`);
    if (minutes > 0) parts.push(`${String(minutes)}m`);
    parts.push(`${String(seconds)}s`);

    return parts.join(' ');
  });

  onMounted(() => {
    if (endsAt && !isExpired.value) {
      timer = setInterval(() => {
        now.value = Date.now();
        if (isExpired.value && timer) {
          clearInterval(timer);
          timer = null;
        }
      }, 1_000);
    }
  });

  onUnmounted(() => {
    if (timer) {
      clearInterval(timer);
    }
  });

  return { remainingMs, isExpired, formatted };
}
