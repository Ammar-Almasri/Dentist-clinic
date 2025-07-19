<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Roles } from '@/Constants/Roles';
import { ref, computed } from 'vue';

const props = defineProps({
    doctor: Object,
});

// Check if user is admin
const isAdmin = computed(() => {
    return props.auth?.user?.role_id === Roles.ADMIN;
});

</script>

<template header>
    <Head :title="`Dr. ${doctor.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="h-6 w-px bg-gray-300"></div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Doctor Profile</h2>
                        <p class="text-gray-600">View detailed information</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3" v-if="isAdmin">
                    <Link
                        :href="route('doctors.edit', doctor.id)"
                        class="px-4 py-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg font-medium transition-colors"
                    >
                        Edit Profile
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Profile Header -->
                    <div class="bg-gradient-to-r from-blue-50 to-teal-50 px-6 py-8 border-b border-gray-200">
                        <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                            <!-- Doctor Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-100 to-teal-100 flex items-center justify-center overflow-hidden border-4 border-white shadow-lg">
                                    <span v-if="!doctor.photo_url" class="text-4xl font-bold text-blue-600">
                                        {{ doctor.name.charAt(0).toUpperCase() }}
                                    </span>
                                    <img
                                        v-else
                                        :src="doctor.photo_url"
                                        :alt="doctor.name"
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                            </div>


                            <!-- Doctor Info -->
                            <div class="text-center md:text-left">
                                <h1 class="text-3xl font-bold text-gray-900 mb-1">Dr. {{ doctor.name }}</h1>
                                <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-sm font-medium mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    {{doctor.speciality || 'General Practitioner'}}
                                </div>
                                <p class="text-gray-600 max-w-lg">
                                    Dedicated healthcare provider with a commitment to patient care and medical excellence.
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
                            <!-- Email Card -->
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-200 transition-colors">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-1">Email Address</h4>
                                        <a :href="`mailto:${doctor.email}`" class="text-lg font-medium text-gray-900 hover:text-blue-600 transition-colors">
                                            {{ doctor.email }}
                                        </a>
                                        <p class="text-sm text-gray-500 mt-2">
                                            Typically responds within 24 hours
                                        </p>
                                    </div>
                                </div>
                            </div>

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
                                        <a :href="`tel:${doctor.phone}`" class="text-lg font-medium text-gray-900 hover:text-blue-600 transition-colors">
                                            {{ doctor.phone }}
                                        </a>
                                        <p class="text-sm text-gray-500 mt-2">
                                            Available Mon-Fri, 9am-5pm
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
                                    :href="route('doctors.index')"
                                    class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors"
                                >
                                    Back to Doctors
                                </Link>
                            </div>

                            <div class="flex items-center space-x-4">
                                <Link
                                    :href="route('doctors.edit', doctor.id)"
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
