<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Roles } from '@/Constants/Roles';

const props = defineProps({
    auth: Object,
});

const isAdmin = computed(() => {
    return props.auth?.user?.role_id === Roles.ADMIN;
});

const form = useForm({
    name: '',
    birth_date: '',
    phone: '',
});

const submit = () => {
    form.post(route('patients.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Add New Patient" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold leading-tight text-gray-800 dark:text-white">Add New Patient</h2>
                <Link :href="route('patients.index')" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                    Back to Patients
                </Link>
            </div>
        </template>

        <div class="py-6">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <!-- Name -->
                        <div class="group">
                            <InputLabel for="name" value="Full Name *" class="mb-1" />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="w-full"
                                required
                                autofocus
                                placeholder="John Smith"
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <!-- Birth Date -->
                        <div class="group">
                            <InputLabel for="birth_date" value="Birth Date *" class="mb-1" />
                            <TextInput
                                id="birth_date"
                                v-model="form.birth_date"
                                type="date"
                                class="w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.birth_date" />
                        </div>

                        <!-- Phone (Admin only) -->
                        <div v-if="isAdmin" class="group">
                            <InputLabel for="phone" value="Phone *" class="mb-1" />
                            <TextInput
                                id="phone"
                                v-model="form.phone"
                                type="tel"
                                class="w-full"
                                required
                                placeholder="0790000000"
                            />
                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <Link :href="route('patients.index')" class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">
                                Cancel
                            </Link>
                            <PrimaryButton
                                class="px-6 py-2"
                                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                                :disabled="form.processing"
                            >
                                <span v-if="!form.processing" class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Save Patient
                                </span>
                                <span v-else class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Saving...
                                </span>
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.group:focus-within label {
    color: #3b82f6; /* blue-500 */
}

.dark .group:focus-within label {
    color: #60a5fa; /* blue-400 */
}
</style>
