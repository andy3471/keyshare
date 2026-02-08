<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import HeroSection from '@/Components/welcome/HeroSection.vue';
import FeaturesSection from '@/Components/welcome/FeaturesSection.vue';
import HowItWorksSection from '@/Components/welcome/HowItWorksSection.vue';
import CtaSection from '@/Components/welcome/CtaSection.vue';
</script>

<template>
  <Head title="Share Game Keys With Friends" />

  <GuestLayout>
    <HeroSection />
    <FeaturesSection />
    <HowItWorksSection />
    <CtaSection />
  </GuestLayout>
</template>
