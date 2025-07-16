<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import BackgroundWrapper from '@/Components/BackgroundWrapper.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <BackgroundWrapper class="overflow-hidden">
        <Head title="Log in" />

        <!-- Decorative elements -->
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-blue-100 dark:bg-blue-900 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-teal-100 dark:bg-teal-900 rounded-full opacity-20 blur-3xl"></div>

        <div class="h-screen flex items-center justify-center p-4">
            <AuthenticationCard class="w-full max-w-md z-10">
                <template #logo>
                    <div class="flex flex-col items-center mb-8">
                        <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-teal-400 rounded-2xl flex items-center justify-center shadow-lg mb-4">
                            <AuthenticationCardLogo />
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Welcome Back</h2>
                        <p class="text-gray-500 dark:text-gray-400">Sign in to your DentistClinic account</p>
                    </div>
                </template>

                <div v-if="status" class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg text-sm">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <InputLabel for="email" value="Email Address" class="mb-2 text-gray-700 dark:text-gray-300" />
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500/50 dark:bg-gray-800/50"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Enter your email"
                        />
                        <InputError class="mt-2 text-sm" :message="form.errors.email" />
                    </div>

                    <div>
                        <InputLabel for="password" value="Password" class="text-gray-700 dark:text-gray-300" />
                        <TextInput
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500/50 dark:bg-gray-800/50"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password"
                        />
                        <InputError class="mt-2 text-sm" :message="form.errors.password" />
                    </div>

                    <div class="flex justify-between items-center mb-1">
                        <div></div>
                        <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-sm text-blue-600 dark:text-blue-400 hover:underline"
                        >
                        Forgot password?
                        </Link>
                    </div>

                    <div class="flex items-center">
                        <Checkbox
                            v-model:checked="form.remember"
                            name="remember"
                            class="h-4 w-4 text-blue-600 dark:text-blue-400 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded"
                        />
                        <InputLabel for="remember" value="Remember me" class="ms-2 text-sm text-gray-600 dark:text-gray-400" />
                    </div>

                    <PrimaryButton
                        class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-teal-500 hover:from-blue-700 hover:to-teal-600 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02] active:scale-95"
                        :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                        :disabled="form.processing"
                    >
                        <span v-if="!form.processing" class="flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                            Log In
                        </span>
                        <span v-else class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </PrimaryButton>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                    Don't have an account?
                    <Link :href="route('register')" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                        Register now
                    </Link>
                </div>
            </AuthenticationCard>
        </div>
    </BackgroundWrapper>
</template>

<style>
/* Custom checkbox styling */
input[type="checkbox"]:checked {
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
}

/* Remove scrollbar */
html, body {
    overflow: hidden;
}
</style>
