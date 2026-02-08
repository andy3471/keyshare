<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import HeroSection from '@/Components/welcome/HeroSection.vue';
import FeaturesSection from '@/Components/welcome/FeaturesSection.vue';
import HowItWorksSection from '@/Components/welcome/HowItWorksSection.vue';
import CtaSection from '@/Components/welcome/CtaSection.vue';
import AppFooter from '@/Components/layout/AppFooter.vue';
</script>

<template>
  <Head title="Share Game Keys With Friends" />

  <div class="min-h-screen bg-dark-950">
    <HeroSection />
    <FeaturesSection />
    <HowItWorksSection />
    <CtaSection />
    <AppFooter />
  </div>
</template>
