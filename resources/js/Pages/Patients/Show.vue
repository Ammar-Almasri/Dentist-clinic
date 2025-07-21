<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Roles } from '@/Constants/Roles';
import { ref, computed } from 'vue';

const props = defineProps({
    patient: Object,
    auth: Object, // Add this line to receive the auth prop
});

// Check if user is admin
const isAdmin = computed(() => {
    return props.auth?.user?.role_id === Roles.ADMIN;
});

// Calculate age from birth date
const patientAge = computed(() => {
    if (!props.patient.birth_date) return null;
    const birthDate = new Date(props.patient.birth_date);
    const ageDiff = Date.now() - birthDate.getTime();
    const ageDate = new Date(ageDiff);
    return Math.abs(ageDate.getUTCFullYear() - 1970);
});
</script>

<template>
    <Head :title="patient.name" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="h-6 w-px bg-gray-300"></div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Patient Profile</h2>
                        <p class="text-gray-600">View detailed information</p>
                    </div>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Profile Header -->
                    <div class="bg-gradient-to-r from-blue-50 to-teal-50 px-6 py-8 border-b border-gray-200">
                        <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                            <!-- Patient Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-100 to-teal-100 flex items-center justify-center overflow-hidden border-4 border-white shadow-lg">
                                    <span v-if="!patient.photo_url" class="text-4xl font-bold text-blue-600">
                                        {{ patient.name.charAt(0).toUpperCase() }}
                                    </span>
                                    <img
                                        v-else
                                        :src="patient.photo_url"
                                        :alt="patient.name"
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                            </div>

                            <!-- Patient Info -->
                            <div class="text-center md:text-left">
                                <h1 class="text-3xl font-bold text-gray-900 mb-1">{{ patient.name }}</h1>
                                <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-sm font-medium mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ patient.birth_date ? new Date(patient.birth_date).toLocaleDateString() : 'No birth date' }}
                                    <span v-if="patientAge" class="ml-2">({{ patientAge }} years)</span>
                                </div>
                                <p class="text-gray-600 max-w-lg">
                                    Patient record containing medical history and contact information.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="px-6 py-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            Contact Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Phone Card -->
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-200 transition-colors">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-1">Phone Number</h4>
                                        <a :href="`tel:${patient.phone}`" class="text-lg font-medium text-gray-900 hover:text-blue-600 transition-colors">
                                            {{ patient.phone || 'Not provided' }}
                                        </a>
                                        <p class="text-sm text-gray-500 mt-2">
                                            Primary contact number
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Birth Date Card -->
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-200 transition-colors">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-1">Birth Date</h4>
                                        <p class="text-lg font-medium text-gray-900">
                                            {{ patient.birth_date ? new Date(patient.birth_date).toLocaleDateString() : 'Not provided' }}
                                        </p>
                                        <p v-if="patientAge" class="text-sm text-gray-500 mt-2">
                                            {{ patientAge }} years old
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gray-50 px-6 py-5 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="flex items-center space-x-4">
                                <Link
                                    :href="route('patients.index')"
                                    class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors"
                                >
                                    Back to Patients
                                </Link>
                            </div>

                            <div class="flex items-center space-x-4">
                                <Link
                                    v-if="isAdmin"
                                    :href="route('patients.edit', patient.id)"
                                    class="flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-md"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Profile
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
