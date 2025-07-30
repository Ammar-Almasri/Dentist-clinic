<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { EnvelopeIcon } from '@heroicons/vue/24/outline';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Forgot Password" />

    <AuthenticationCard>
        <template #logo>
            <div class="flex justify-center mb-8">
                <AuthenticationCardLogo class="h-16 w-auto text-gray-900 dark:text-white" />
            </div>
        </template>

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Reset Your Password</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Enter your email and we'll send you a link to reset your password.
            </p>
        </div>

        <div v-if="status" class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/30 border border-green-100 dark:border-green-800">
            <p class="text-sm font-medium text-green-600 dark:text-green-400">
                {{ status }}
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <EnvelopeIcon class="h-5 w-5 text-gray-400 dark:text-gray-500" />
                    </div>
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="pl-10 w-full"
                        placeholder="your@email.com"
                        required
                        autofocus
                        autocomplete="email"
                    />
                </div>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    class="w-full justify-center"
                >
                    <span v-if="!form.processing">Send Reset Link</span>
                    <span v-else>Sending...</span>
                </PrimaryButton>
            </div>
        </form>

        <div class="mt-6 text-center">
            <a
                :href="route('login')"
                class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300"
            >
                Remember your password? Sign in
            </a>
        </div>
    </AuthenticationCard>
</template>
