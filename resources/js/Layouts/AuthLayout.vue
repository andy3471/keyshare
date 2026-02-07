<template>
    <div class="min-h-screen bg-dark-950 flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <div class="flex justify-center mb-8">
                <img
                    :src="'/images/logo_default.png'"
                    alt="Keyshare Logo"
                    class="w-32 h-24"
                />
            </div>
            
            <div class="bg-dark-800 rounded-lg shadow-xl p-8 border border-dark-700">
                <slot />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
// Auth layout for login/register pages
</script>
