<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    doctors: Array,
});

const searchQuery = ref('');
const selectedSpecialty = ref('all');
const sortOption = ref('name_asc');

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

// Filter and sort doctors
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

    // Sort results
    switch(sortOption.value) {
        case 'name_asc':
            return results.sort((a, b) => a.name.localeCompare(b.name));
        case 'name_desc':
            return results.sort((a, b) => b.name.localeCompare(a.name));
        case 'experience_asc':
            return results.sort((a, b) => (a.years_experience || 0) - (b.years_experience || 0));
        case 'experience_desc':
            return results.sort((a, b) => (b.years_experience || 0) - (a.years_experience || 0));
        default:
            return results;
    }
});
</script>

<template>
    <Head title="Doctors" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h2 class="text-2xl font-bold leading-tight text-gray-800 dark:text-white">Our Medical Team</h2>
                <div class="mt-4 md:mt-0">
                    <Link :href="route('doctors.create')">
                        <PrimaryButton class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                            Add New Doctor
                        </PrimaryButton>
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Filters and Search -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search Input -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input
                                v-model="searchQuery"
                                type="text"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Search doctors..."
                            />
                        </div>

                        <!-- Specialty Filter -->
                        <div>
                            <select
                                v-model="selectedSpecialty"
                                class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                            >
                                <option v-for="specialty in specialties" :key="specialty" :value="specialty">
                                    {{ specialty === 'all' ? 'All Specialties' : specialty }}
                                </option>
                            </select>
                        </div>

                        <!-- Sort Options -->
                        <div>
                            <select
                                v-model="sortOption"
                                class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                            >
                                <option value="name_asc">Sort by: Name (A-Z)</option>
                                <option value="name_desc">Sort by: Name (Z-A)</option>
                                <option value="experience_asc">Sort by: Experience (Low-High)</option>
                                <option value="experience_desc">Sort by: Experience (High-Low)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Doctors Grid -->
                <div v-if="filteredDoctors.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <div v-for="doctor in filteredDoctors" :key="doctor.id" class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="p-5">
                            <!-- Doctor Avatar -->
                            <div class="flex justify-center mb-4">
                                <div class="relative">
                                    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-100 to-teal-100 dark:from-blue-900 dark:to-teal-900 flex items-center justify-center overflow-hidden">
                                        <span v-if="!doctor.photo" class="text-3xl font-bold text-blue-600 dark:text-blue-300">
                                            {{ doctor.name.charAt(0).toUpperCase() }}
                                        </span>
                                        <img v-else :src="doctor.photo" :alt="doctor.name" class="w-full h-full object-cover">
                                    </div>
                                    <div class="absolute bottom-0 right-0 w-6 h-6 rounded-full bg-green-500 border-2 border-white dark:border-gray-800 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Doctor Info -->
                            <div class="text-center">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-1">{{ doctor.name }}</h3>
                                <p class="text-blue-600 dark:text-blue-400 font-medium mb-2">{{ doctor.speciality || 'General Practitioner' }}</p>

                                <div class="flex items-center justify-center text-sm text-gray-600 dark:text-gray-300 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ doctor.years_experience || 'N/A' }} years experience
                                </div>

                                <div v-if="doctor.hospital" class="flex items-center justify-center text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ doctor.hospital }}
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-center space-x-2 mt-4">
                                <Link :href="route('doctors.show', doctor.id)" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </Link>
                                <Link :href="route('doctors.edit', doctor.id)" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No doctors found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Try adjusting your search or filter to find what you're looking for.
                    </p>
                    <div class="mt-6">
                        <button
                            @click="searchQuery = ''; selectedSpecialty = 'all'"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Reset filters
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Smooth transitions for hover effects */
.doctor-card {
    transition: all 0.3s ease;
}

.doctor-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Dark mode transitions */
.dark .doctor-card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.dark .doctor-card:hover {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}
</style>
