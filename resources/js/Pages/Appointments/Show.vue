<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    CalendarDaysIcon,
    UserIcon,
    BuildingOffice2Icon,
    ClockIcon,
    CogIcon,
    ArrowLeftIcon
} from '@heroicons/vue/24/outline';
import { Status } from '@/Constants/Status';

const props = defineProps({
    appointment: Object,
});

const statuses = {
    [Status.PENDING]: { label: 'Pending', color: 'bg-yellow-100 text-yellow-800' },
    [Status.CONFIRMED]: { label: 'Confirmed', color: 'bg-green-100 text-green-800' },
};

const formatDateTime = (dateTime) => {
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(dateTime).toLocaleString(undefined, options);
};
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="`Appointment Details`" />

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Appointment Details
                </h2>
                <Link
                    :href="route('appointments.index')"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    <ArrowLeftIcon class="h-4 w-4 mr-2" />
                    Back to Appointments
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Header with status -->
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Appointment #{{ appointment.id }}
                            </h3>
                            <span
                                :class="['mt-1 px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full', statuses[appointment.status].color]"
                            >
                                {{ statuses[appointment.status].label }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-500">
                            Created {{ new Date(appointment.created_at).toLocaleDateString() }}
                        </div>
                    </div>

                    <!-- Main content -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Patient Information -->
                            <div class="bg-indigo-50 p-6 rounded-lg">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <UserIcon class="h-5 w-5 text-indigo-600" />
                                    </div>
                                    <h3 class="ml-3 text-lg font-medium text-indigo-800">Patient Information</h3>
                                </div>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Name</p>
                                        <p class="text-base">{{ appointment.patient.name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Phone</p>
                                        <p class="text-base">{{ appointment.patient.phone }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Email</p>
                                        <p class="text-base">{{ appointment.patient.email || 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Doctor Information -->
                            <div class="bg-teal-50 p-6 rounded-lg">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center">
                                        <BuildingOffice2Icon class="h-5 w-5 text-teal-600" />
                                    </div>
                                    <h3 class="ml-3 text-lg font-medium text-teal-800">Doctor Information</h3>
                                </div>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Name</p>
                                        <p class="text-base">Dr. {{ appointment.doctor.name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Specialization</p>
                                        <p class="text-base">{{ appointment.doctor.specialization }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Phone</p>
                                        <p class="text-base">{{ appointment.doctor.phone || 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Appointment Details -->
                        <div class="mt-8 bg-white border border-gray-200 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <CalendarDaysIcon class="h-5 w-5 text-blue-600" />
                                </div>
                                <h3 class="ml-3 text-lg font-medium text-blue-800">Appointment Details</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Date & Time</p>
                                    <p class="text-lg font-medium">
                                        {{ formatDateTime(appointment.appointment_date) }}
                                    </p>
                                </div>
                                <div v-if="appointment.service">
                                    <p class="text-sm font-medium text-gray-500">Service</p>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                            <CogIcon class="h-4 w-4 text-purple-600" />
                                        </div>
                                        <div>
                                            <p class="text-lg font-medium">{{ appointment.service.name }}</p>
                                            <p class="text-sm text-gray-500" v-if="appointment.service.duration">
                                                Duration: {{ appointment.service.duration }} minutes
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <p class="text-sm font-medium text-gray-500">Service</p>
                                    <p class="text-lg font-medium text-gray-400">No specific service</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-8 flex justify-end space-x-3">
                            <Link
                                :href="route('appointments.edit', appointment.id)"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Edit Appointment
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
