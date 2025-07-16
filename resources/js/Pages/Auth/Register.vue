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

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <BackgroundWrapper>
        <Head title="Register" />

        <!-- Animated background elements -->
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-blue-100 dark:bg-blue-900 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-teal-100 dark:bg-teal-900 rounded-full opacity-20 blur-3xl"></div>

        <div class="h-screen flex items-center justify-center p-3 overflow-hidden">
            <AuthenticationCard class="w-full max-w-md z-10 transform transition-all duration-500 hover:shadow-2xl">
                <template #logo>
                    <div class="flex flex-col items-center mb-3">
                        <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-teal-400 rounded-2xl flex items-center justify-center shadow-lg mb-2">
                            <AuthenticationCardLogo class="text-white" />
                        </div>
                    </div>
                </template>

                <form @submit.prevent="submit" class="space-y-3">
                    <!-- Name Field -->
                    <div class="group">
                        <InputLabel for="name" value="Full Name" class="mb-1 text-sm text-gray-700 dark:text-gray-300 group-focus-within:text-blue-600 transition-colors" />
                        <div class="relative">
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800/50 transition-all duration-300 pl-10 text-sm"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="John Doe"
                            />
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <InputError class="mt-1 text-xs" :message="form.errors.name" />
                    </div>

                    <!-- Email Field -->
                    <div class="group">
                        <InputLabel for="email" value="Email Address" class="mb-1 text-sm text-gray-700 dark:text-gray-300 group-focus-within:text-blue-600 transition-colors" />
                        <div class="relative">
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800/50 transition-all duration-300 pl-10 text-sm"
                                required
                                autocomplete="username"
                                placeholder="your@email.com"
                            />
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <InputError class="mt-1 text-xs" :message="form.errors.email" />
                    </div>

                    <!-- Phone Field -->
                    <div class="group">
                        <InputLabel for="phone" value="Phone Number" class="mb-1 text-sm text-gray-700 dark:text-gray-300 group-focus-within:text-blue-600 transition-colors" />
                        <div class="relative">
                            <TextInput
                                id="phone"
                                v-model="form.phone"
                                type="tel"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800/50 transition-all duration-300 pl-10 text-sm"
                                required
                                autocomplete="tel"
                                placeholder="0790000000"
                            />
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                        </div>
                        <InputError class="mt-1 text-xs" :message="form.errors.phone" />
                    </div>

                    <!-- Password Field -->
                    <div class="group">
                        <InputLabel for="password" value="Password" class="mb-1 text-sm text-gray-700 dark:text-gray-300 group-focus-within:text-blue-600 transition-colors" />
                        <div class="relative">
                            <TextInput
                                id="password"
                                v-model="form.password"
                                type="password"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800/50 transition-all duration-300 pl-10 text-sm"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                            />
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                        <InputError class="mt-1 text-xs" :message="form.errors.password" />
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="group">
                        <InputLabel for="password_confirmation" value="Confirm Password" class="mb-1 text-sm text-gray-700 dark:text-gray-300 group-focus-within:text-blue-600 transition-colors" />
                        <div class="relative">
                            <TextInput
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800/50 transition-all duration-300 pl-10 text-sm"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                            />
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <InputError class="mt-1 text-xs" :message="form.errors.password_confirmation" />
                    </div>

                    <!-- Terms Checkbox -->
                    <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-2">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <Checkbox
                                    id="terms"
                                    v-model:checked="form.terms"
                                    name="terms"
                                    class="h-4 w-4 text-blue-600 dark:text-blue-400 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded transition-colors"
                                />
                            </div>
                            <div class="ml-3">
                                <label for="terms" class="text-xs text-gray-600 dark:text-gray-400">
                                    I agree to the <a :href="route('terms.show')" class="text-blue-600 dark:text-blue-400 hover:underline font-medium" target="_blank">Terms of Service</a> and <a :href="route('policy.show')" class="text-blue-600 dark:text-blue-400 hover:underline font-medium" target="_blank">Privacy Policy</a>
                                </label>
                                <InputError class="mt-1 text-xs" :message="form.errors.terms" />
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-4">
                        <PrimaryButton
                            class="w-full py-2.5 px-4 bg-gradient-to-r from-blue-600 to-teal-500 hover:from-blue-700 hover:to-teal-600 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] text-sm"
                            :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                            :disabled="form.processing"
                        >
                            <span v-if="!form.processing" class="flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                                </svg>
                                Create Account
                            </span>
                            <span v-else class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </PrimaryButton>
                    </div>

                    <!-- Login Link -->
                    <div class="mt-3 text-center text-xs text-gray-600 dark:text-gray-400">
                        Already have an account?
                        <Link :href="route('login')" class="text-blue-600 dark:text-blue-400 hover:underline font-medium ml-1">
                            Sign in
                        </Link>
                    </div>
                </form>
            </AuthenticationCard>
        </div>
    </BackgroundWrapper>
</template>

<style>
@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

.animate-float {
    animation: float 8s ease-in-out infinite;
}

.animate-float-delay {
    animation: float 10s ease-in-out infinite 2s;
}

.animate-float-slow {
    animation: float 12s ease-in-out infinite 1s;
}

/* Custom checkbox styling */
input[type="checkbox"]:checked {
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
}
</style>
