<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
    doctor: Object,
});

const form = useForm({
    name: props.doctor.name || '',
    speciality: props.doctor.speciality || '',
    phone: props.doctor.phone || '',
    _method: 'PUT'
});

const submit = () => {
    form.post(route('doctors.update', props.doctor.id), {
        preserveScroll: true,
        onSuccess: () => {
            // Success handled by backend redirect
        },
    });
};
</script>

<template>
    <Head title="Edit Doctor" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <Link
                        :href="route('doctors.index')"
                        class="flex items-center text-gray-500 hover:text-gray-700 transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to Doctors
                    </Link>
                    <div class="h-6 w-px bg-gray-300"></div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Edit Doctor</h2>
                        <p class="text-gray-600">Update doctor basic information</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <Link
                        :href="route('doctors.show', doctor.id)"
                        class="px-4 py-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg font-medium transition-colors"
                    >
                        View Profile
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="space-y-8">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Basic Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Dr. John Smith"
                                />
                                <div v-if="form.errors.name" class="text-red-600 text-sm mt-2">{{ form.errors.name }}</div>
                            </div>

                            <!-- Speciality -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Speciality</label>
                                <input
                                    v-model="form.speciality"
                                    type="text"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="john@example.com"
                                />
                                <div v-if="form.errors.speciality" class="text-red-600 text-sm mt-2">{{ form.errors.speciality }}</div>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input
                                    v-model="form.phone"
                                    type="tel"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="0790000000"
                                />
                                <div v-if="form.errors.phone" class="text-red-600 text-sm mt-2">{{ form.errors.phone }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="flex items-center space-x-4">
                                <Link
                                    :href="route('doctors.index')"
                                    class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors"
                                >
                                    Cancel
                                </Link>
                            </div>

                            <div class="flex items-center space-x-4">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-medium rounded-lg transition-colors shadow-lg"
                                >
                                    <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{ form.processing ? 'Saving...' : 'Save Changes' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
