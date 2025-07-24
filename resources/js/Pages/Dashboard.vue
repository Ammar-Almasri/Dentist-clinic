<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" /> <!-- This sets the page title -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clinic Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-8 sm:p-12">
                        <div class="text-center mb-12">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome to Your Clinic Portal</h1>
                            <p class="text-lg text-gray-600">Manage your healthcare operations efficiently</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                            <!-- Patients Card -->
                            <Link
                                :href="route('patients.index')"
                                class="group relative bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-blue-100 hover:border-blue-200 overflow-hidden"
                            >
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-200 rounded-full opacity-20"></div>
                                <div class="relative z-10">
                                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4 mx-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-center text-gray-800 mb-2">Patient Management</h3>
                                    <p class="text-gray-600 text-center text-sm">View and manage patient records and appointments</p>
                                    <div class="mt-6 flex justify-center">
                                        <span class="px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-medium shadow-sm group-hover:bg-blue-50 transition-colors">
                                            Go to Patients
                                        </span>
                                    </div>
                                </div>
                            </Link>

                            <!-- Doctors Card -->
                            <Link
                                :href="route('doctors.index')"
                                class="group relative bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-teal-100 hover:border-teal-200 overflow-hidden"
                            >
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-teal-200 rounded-full opacity-20"></div>
                                <div class="relative z-10">
                                    <div class="w-16 h-16 bg-teal-100 rounded-lg flex items-center justify-center mb-4 mx-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-center text-gray-800 mb-2">Doctor Management</h3>
                                    <p class="text-gray-600 text-center text-sm">View and manage doctor schedules and availability</p>
                                    <div class="mt-6 flex justify-center">
                                        <span class="px-4 py-2 bg-white text-teal-600 rounded-lg text-sm font-medium shadow-sm group-hover:bg-teal-50 transition-colors">
                                            Go to Doctors
                                        </span>
                                    </div>
                                </div>
                            </Link>

                            <!-- Appointments Card -->
                            <Link
                                :href="route('appointments.index')"
                                class="group relative bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-purple-100 hover:border-purple-200 overflow-hidden"
                            >
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-200 rounded-full opacity-20"></div>
                                <div class="relative z-10">
                                    <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mb-4 mx-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-center text-gray-800 mb-2">Appointments</h3>
                                    <p class="text-gray-600 text-center text-sm">View and manage all clinic appointments</p>
                                    <div class="mt-6 flex justify-center">
                                        <span class="px-4 py-2 bg-white text-purple-600 rounded-lg text-sm font-medium shadow-sm group-hover:bg-purple-50 transition-colors">
                                            Go to Appointments
                                        </span>
                                    </div>
                                </div>
                            </Link>
                        </div>

                        <div class="mt-16 text-center">
                            <p class="text-gray-500 text-sm">Need help? <a href="#" class="text-blue-500 hover:text-blue-700">Contact support</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
