<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { ref, computed } from 'vue';
import {
    PencilSquareIcon,
    TrashIcon,
    EyeIcon,
    CalendarDaysIcon,
    UserIcon,
    BuildingOffice2Icon,
    ClockIcon,
    FunnelIcon,
    ArrowUpIcon,
    ArrowDownIcon,
    ChevronUpDownIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
    appointments: Object,
});

const statuses = {
    0: { label: 'Pending', color: 'bg-yellow-100 text-yellow-800' },
    1: { label: 'Confirmed', color: 'bg-green-100 text-green-800' },
    2: { label: 'Cancelled', color: 'bg-red-100 text-red-800' },
    3: { label: 'Completed', color: 'bg-blue-100 text-blue-800' },
};

// Sorting
const sortField = ref('appointment_date');
const sortDirection = ref('desc');

const sort = (field) => {
    if (sortField.value === field) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortField.value = field;
        sortDirection.value = 'asc';
    }
    fetchAppointments();
};

// Filtering
const filters = ref({
    status: '',
    date_from: '',
    date_to: '',
    doctor_id: '',
    patient_id: '',
});

const fetchAppointments = () => {
    const params = {
        sort: sortField.value,
        direction: sortDirection.value,
        ...filters.value,
    };

    router.get(route('appointments.index'), params, {
        preserveState: true,
        replace: true,
    });
};

const resetFilters = () => {
    filters.value = {
        status: '',
        date_from: '',
        date_to: '',
        doctor_id: '',
        patient_id: '',
    };
    fetchAppointments();
};

const formatDateTime = (dateTime) => {
    const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(dateTime).toLocaleString(undefined, options);
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Appointments" />

        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Appointments Management
                </h2>
                <Link
                    :href="route('appointments.create')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                    New Appointment
                </Link>
            </div>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Filters -->
                        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                    <FunnelIcon class="h-5 w-5 mr-2" />
                                    Filters
                                </h3>
                                <button
                                    @click="resetFilters"
                                    class="text-sm text-indigo-600 hover:text-indigo-800"
                                >
                                    Reset Filters
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select
                                        v-model="filters.status"
                                        @change="fetchAppointments"
                                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    >
                                        <option value="">All Statuses</option>
                                        <option v-for="(status, key) in statuses" :value="key">{{ status.label }}</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                                    <input
                                        type="date"
                                        v-model="filters.date_from"
                                        @change="fetchAppointments"
                                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                                    <input
                                        type="date"
                                        v-model="filters.date_to"
                                        @change="fetchAppointments"
                                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Appointments Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <button
                                                @click="sort('appointment_date')"
                                                class="flex items-center space-x-1 group"
                                            >
                                                <CalendarDaysIcon class="h-4 w-4" />
                                                <span>Date & Time</span>
                                                <ChevronUpDownIcon
                                                    v-if="sortField !== 'appointment_date'"
                                                    class="h-4 w-4 opacity-0 group-hover:opacity-100"
                                                />
                                                <ArrowUpIcon
                                                    v-else-if="sortDirection === 'asc'"
                                                    class="h-4 w-4"
                                                />
                                                <ArrowDownIcon
                                                    v-else
                                                    class="h-4 w-4"
                                                />
                                            </button>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <button
                                                @click="sort('patient_id')"
                                                class="flex items-center space-x-1 group"
                                            >
                                                <UserIcon class="h-4 w-4" />
                                                <span>Patient</span>
                                                <ChevronUpDownIcon
                                                    v-if="sortField !== 'patient_id'"
                                                    class="h-4 w-4 opacity-0 group-hover:opacity-100"
                                                />
                                                <ArrowUpIcon
                                                    v-else-if="sortDirection === 'asc'"
                                                    class="h-4 w-4"
                                                />
                                                <ArrowDownIcon
                                                    v-else
                                                    class="h-4 w-4"
                                                />
                                            </button>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <button
                                                @click="sort('doctor_id')"
                                                class="flex items-center space-x-1 group"
                                            >
                                                <BuildingOffice2Icon class="h-4 w-4" />
                                                <span>Doctor</span>
                                                <ChevronUpDownIcon
                                                    v-if="sortField !== 'doctor_id'"
                                                    class="h-4 w-4 opacity-0 group-hover:opacity-100"
                                                />
                                                <ArrowUpIcon
                                                    v-else-if="sortDirection === 'asc'"
                                                    class="h-4 w-4"
                                                />
                                                <ArrowDownIcon
                                                    v-else
                                                    class="h-4 w-4"
                                                />
                                            </button>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Service
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <button
                                                @click="sort('status')"
                                                class="flex items-center space-x-1 group"
                                            >
                                                <ClockIcon class="h-4 w-4" />
                                                <span>Status</span>
                                                <ChevronUpDownIcon
                                                    v-if="sortField !== 'status'"
                                                    class="h-4 w-4 opacity-0 group-hover:opacity-100"
                                                />
                                                <ArrowUpIcon
                                                    v-else-if="sortDirection === 'asc'"
                                                    class="h-4 w-4"
                                                />
                                                <ArrowDownIcon
                                                    v-else
                                                    class="h-4 w-4"
                                                />
                                            </button>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="appointment in appointments.data" :key="appointment.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ formatDateTime(appointment.appointment_date) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                        <UserIcon class="h-5 w-5 text-indigo-600" />
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ appointment.patient.name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ appointment.patient.phone }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center">
                                                        <BuildingOffice2Icon class="h-5 w-5 text-teal-600" />
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        Dr. {{ appointment.doctor.name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ appointment.doctor.specialization }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ appointment.service?.name || 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                :class="['px-2 inline-flex text-xs leading-5 font-semibold rounded-full', statuses[appointment.status].color]"
                                            >
                                                {{ statuses[appointment.status].label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <Link
                                                    :href="route('appointments.show', appointment.id)"
                                                    class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50"
                                                    title="View"
                                                >
                                                    <EyeIcon class="h-5 w-5" />
                                                </Link>
                                                <Link
                                                    :href="route('appointments.edit', appointment.id)"
                                                    class="text-yellow-600 hover:text-yellow-900 p-1 rounded hover:bg-yellow-50"
                                                    title="Edit"
                                                >
                                                    <PencilSquareIcon class="h-5 w-5" />
                                                </Link>
                                                <button
                                                    @click="confirmDelete(appointment.id)"
                                                    class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50"
                                                    title="Delete"
                                                >
                                                    <TrashIcon class="h-5 w-5" />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="appointments.data.length === 0">
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No appointments found.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            <Pagination :links="appointments.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
