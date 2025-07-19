<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, computed } from 'vue';
import { Roles } from '@/Constants/Roles';

const props = defineProps({
    doctors: Array,
    auth: Object, // Add auth prop to check user role
});

const searchQuery = ref('');
const selectedSpecialty = ref('all');

// Check if user is admin
const isAdmin = computed(() => {
    return props.auth?.user?.role_id === Roles.ADMIN;
});

// Extract unique specialties
const specialties = computed(() => {
    const unique = new Set();
    props.doctors.forEach(doctor => {
        if (doctor.specialty) {
            unique.add(doctor.specialty);
        }
    });
    return ['all', ...Array.from(unique).sort()];
});

// Filter doctors (removed sorting functionality)
const filteredDoctors = computed(() => {
    let results = props.doctors;

    // Filter by search query
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        results = results.filter(doctor =>
            doctor.name.toLowerCase().includes(query) ||
            (doctor.specialty && doctor.specialty.toLowerCase().includes(query)) ||
            (doctor.hospital && doctor.hospital.toLowerCase().includes(query))
        );
    }

    // Filter by specialty
    if (selectedSpecialty.value !== 'all') {
        results = results.filter(doctor => doctor.specialty === selectedSpecialty.value);
    }

    return results;
});
</script>

<template >
    <Head title="Doctors" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Our Medical Team</h2>
                    <p class="mt-2 text-gray-600">Find and connect with our specialist doctors</p>
                </div>
                <div class="flex items-center gap-4">
                    <Link :href="route('dashboard')" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back to Dashboard
                    </Link>
                    <Link v-if="isAdmin" :href="route('doctors.create')">
                        <PrimaryButton class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                            Add New Doctor
                        </PrimaryButton>
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Filters and Search -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-200">
                    <div class="flex flex-col md:flex-row gap-4 items-end">
                        <!-- Search Input -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Search by name, specialty, or hospital..."
                                />
                            </div>
                        </div>

                        <!-- Specialty Filter -->
                        <div class="w-full md:w-64">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Specialty</label>
                            <select
                                v-model="selectedSpecialty"
                                class="block w-full px-4 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-lg bg-white text-gray-900 transition duration-200"
                            >
                                <option v-for="specialty in specialties" :key="specialty" :value="specialty">
                                    {{ specialty === 'all' ? 'All Specialties' : specialty }}
                                </option>
                            </select>
                        </div>

                        <!-- Reset Button -->
                        <div class="w-full md:w-auto">
                            <button
                                @click="searchQuery = ''; selectedSpecialty = 'all'"
                                class="w-full md:w-auto px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-200 border border-gray-300"
                                :class="{ 'opacity-50': !searchQuery && selectedSpecialty === 'all' }"
                                :disabled="!searchQuery && selectedSpecialty === 'all'"
                            >
                                Reset
                            </button>
                        </div>
                    </div>

                    <!-- Results Count -->
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-600">
                            Showing {{ filteredDoctors.length }} of {{ doctors.length }} doctors
                        </p>
                    </div>
                </div>

                <!-- Doctors Grid -->
                <div v-if="filteredDoctors.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <div
                        v-for="doctor in filteredDoctors"
                        :key="doctor.id"
                        class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 hover:border-blue-200 group"
                    >
                        <div class="p-6">
                            <!-- Doctor Avatar -->
                            <div class="flex justify-center mb-5">
                                <div class="relative">
                                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-50 via-blue-100 to-teal-50 flex items-center justify-center overflow-hidden border-2 border-blue-100">
                                        <span v-if="!doctor.photo_url" class="text-2xl font-bold text-blue-600">
                                            {{ doctor.name.charAt(0).toUpperCase() }}
                                        </span>
                                        <img
                                            v-else
                                            :src="doctor.photo_url"
                                            :alt="doctor.name"
                                            class="w-full h-full object-cover"
                                        >
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-green-500 border-2 border-white flex items-center justify-center shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Doctor Info -->
                            <div class="text-center">
                                <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-blue-700 transition-colors">{{ doctor.name }}</h3>
                                <p class="text-blue-600 font-medium text-sm mb-3">{{ doctor.speciality || 'General Practitioner' }}</p>

                                <div class="flex items-center justify-center text-xs text-gray-600 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ doctor.years_experience || 0 }} years experience
                                </div>

                                <div v-if="doctor.hospital" class="flex items-center justify-center text-xs text-gray-500 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ doctor.hospital }}
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-center space-x-3 mt-5">
                                <Link
                                    :href="route('doctors.show', doctor.id)"
                                    class="flex items-center justify-center px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors duration-200 text-sm font-medium"
                                    title="View Details"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View
                                </Link>

                                <Link
                                    v-if="isAdmin"
                                    :href="route('doctors.edit', doctor.id)"
                                    class="flex items-center justify-center px-4 py-2 bg-green-50 text-green-600 hover:bg-green-100 rounded-lg transition-colors duration-200 text-sm font-medium"
                                    title="Edit Doctor"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="bg-white rounded-xl shadow-sm p-12 text-center border border-gray-200">
                    <div class="max-w-md mx-auto">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No doctors found</h3>
                        <p class="text-gray-500 mb-6">
                            Try adjusting your search criteria or browse all available doctors.
                        </p>
                        <button
                            @click="searchQuery = ''; selectedSpecialty = 'all'"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset filters
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
