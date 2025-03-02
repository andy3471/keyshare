<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthBase title="Log in to your account" description="Enter your email and password below to log in">
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        v-model="form.email"
                        placeholder="email@example.com"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password">Password</Label>
                        <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm" :tabindex="5">
                            Forgot password?
                        </TextLink>
                    </div>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        v-model="form.password"
                        placeholder="Password"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="flex items-center justify-between" :tabindex="3">
                    <Label for="remember" class="flex items-center space-x-3">
                        <Checkbox id="remember" v-model:checked="form.remember" :tabindex="4" />
                        <span>Remember me</span>
                    </Label>
                </div>

                <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Log in
                </Button>
            </div>

            <div class="flex flex-col gap-4">
                <Button as="a" :href="route('login.linked-accounts.steam.redirect')" class="w-full bg-[#171a21] hover:bg-[#2a475e]">
                    <img src="/icons/steam-icon.png" alt="Steam" class="h-5 w-5 mr-2" />
                    Log in with Steam
                </Button>
                <Button as="a" :href="route('login.linked-accounts.microsoft.redirect')" class="w-full bg-[#00a1f1] hover:bg-[#0078d7]">
                    <img src="/icons/microsoft-icon.png" alt="Microsoft" class="h-5 w-5 mr-2" />
                    Log in with Microsoft
                </Button>
                <Button as="a" :href="route('login.linked-accounts.battlenet.redirect')" class="w-full bg-[#148eff] hover:bg-[#0e6eb8]">
                    <img src="/icons/battlenet-icon.png" alt="BattleNet" class="h-5 w-5 mr-2" />
                    Log in with BattleNet
                </Button>
                <Button as="a" :href="route('login.linked-accounts.discord.redirect')" class="w-full bg-[#5865f2] hover:bg-[#4752c4]">
                    <img src="/icons/discord-icon.png" alt="Discord" class="h-5 w-5 mr-2" />
                    Log in with Discord
                </Button>
                <Button as="a" :href="route('login.linked-accounts.twitch.redirect')" class="w-full bg-[#9146ff] hover:bg-[#772ce8]">
                    <img src="/icons/twitch-icon.png" alt="Twitch" class="h-5 w-5 mr-2" />
                    Log in with Twitch
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Don't have an account?
                <TextLink :href="route('register')" :tabindex="5">Sign up</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
