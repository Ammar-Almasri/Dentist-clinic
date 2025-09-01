<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { CalendarIcon, UserIcon, BuildingOffice2Icon, CogIcon, ClockIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    patients: Array,
    doctors: Array,
});

const form = useForm({
    patient_id: '',
    doctor_id: '',
    service_id: null,
    appointment_date: '',
    appointment_time: '',
});

const submit = () => {
    const combinedDateTime = `${form.appointment_date}T${form.appointment_time}`;

    form.transform((data) => ({
        ...data,
        appointment_date: combinedDateTime
    })).post(route('appointments.store'));
};
</script>


<template>
    <AuthenticatedLayout>
        <Head title="Create Appointment" />

        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Create New Appointment
                </h2>
                <Link
                    :href="route('appointments.index')"
                    class="text-sm text-gray-600 hover:text-gray-900"
                >
                    Back to Appointments
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Patient Selection -->
                            <div>
                                <InputLabel for="patient_id" value="Patient" />
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <UserIcon class="h-5 w-5 text-gray-400" />
                                    </div>
                                    <select
                                        id="patient_id"
                                        v-model="form.patient_id"
                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        :class="{ 'border-red-300': form.errors.patient_id }"
                                    >
                                        <option value="">Select a patient</option>
                                        <option
                                            v-for="patient in patients"
                                            :key="patient.id"
                                            :value="patient.id"
                                        >
                                            {{ patient.name }} ({{ patient.phone }})
                                        </option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.patient_id" />
                            </div>

                            <!-- Doctor Selection -->
                            <div>
                                <InputLabel for="doctor_id" value="Doctor" />
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <BuildingOffice2Icon class="h-5 w-5 text-gray-400" />
                                    </div>
                                    <select
                                        id="doctor_id"
                                        v-model="form.doctor_id"
                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        :class="{ 'border-red-300': form.errors.doctor_id }"
                                    >
                                        <option value="">Select a doctor</option>
                                        <option
                                            v-for="doctor in doctors"
                                            :key="doctor.id"
                                            :value="doctor.id"
                                        >
                                            Dr. {{ doctor.name }} ({{ doctor.speciality }})
                                        </option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.doctor_id" />
                            </div>

                            <!-- Service Selection -->
                            <div>
                                <InputLabel for="service_id" value="Service (Optional)" />
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <CogIcon class="h-5 w-5 text-gray-400" />
                                    </div>
                                    <select
                                        id="service_id"
                                        v-model="form.service_id"
                                        :disabled="!form.doctor_id"
                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        :class="{ 'border-red-300': form.errors.service_id }"
                                    >
                                        <option :value="null">No specific service</option>
                                        <option
                                            v-for="service in (doctors.find(d => d.id === Number(form.doctor_id))?.services || [])"
                                            :key="service.id"
                                            :value="service.id"
                                        >
                                            {{ service.name }} ({{ service.duration }} mins)
                                        </option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.service_id" />
                            </div>


                            <!-- Date and Time Selection -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <InputLabel for="appointment_date" value="Appointment Date" />
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <CalendarIcon class="h-5 w-5 text-gray-400" />
                                        </div>
                                        <input
                                            type="date"
                                            id="appointment_date"
                                            v-model="form.appointment_date"
                                            :min="new Date().toISOString().split('T')[0]"
                                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'border-red-300': form.errors.appointment_date }"
                                        />
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.appointment_date" />
                                </div>

                                <div>
                                <InputLabel for="appointment_time" value="Appointment Time" />
                                <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <ClockIcon class="h-5 w-5 text-gray-400" />
                                        </div>
                                        <input
                                            type="time"
                                            id="appointment_time"
                                            v-model="form.appointment_time"
                                            min="08:00"
                                            max="16:00"
                                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'border-red-300': form.errors.appointment_date }"
                                        />
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Available between 8:00 AM and 4:00 PM</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-8">
                                <Link
                                    :href="route('appointments.index')"
                                    class="mr-4 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    Cancel
                                </Link>
                                <PrimaryButton
                                    type="submit"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Create Appointment
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
