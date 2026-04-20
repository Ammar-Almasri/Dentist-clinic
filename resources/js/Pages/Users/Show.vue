<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Roles } from '@/Constants/Roles';
import { computed, ref } from 'vue';

const props = defineProps({
    user: Object,
    auth: Object,
});

const isAdmin = computed(() => props.auth?.user?.role_id === Roles.ADMIN || props.auth?.user?.role_id === Roles.SUPER_ADMIN);
const initials = (name) => name?.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase() ?? '?';

const editing = ref(false);

const form = useForm({
    email: props.user.email,
    phone: props.user.phone ?? '',
});

const submit = () => {
    form.put(route('users.update', props.user.id), {
        onSuccess: () => editing.value = false,
    });
};

const deletePatient = (patientId) => {
    if (confirm('Are you sure you want to delete this patient?')) {
        router.delete(route('patients.destroy', patientId));
    }
};
</script>

<template>
    <Head :title="user.name" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <div class="h-6 w-px bg-gray-300"></div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">User Profile</h2>
                    <p class="text-gray-600">Account and linked patients</p>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-50 to-teal-50 px-6 py-8 border-b border-gray-200 flex items-center gap-6">
                        <div class="w-20 h-20 rounded-full bg-blue-100 border-4 border-white shadow flex items-center justify-center flex-shrink-0">
                            <span class="text-2xl font-bold text-blue-600">{{ initials(user.name) }}</span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ user.name }}</h1>
                            <p class="text-gray-500 text-sm mt-0.5">{{ user.email }}</p>
                            <span class="inline-flex items-center mt-2 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active account
                            </span>
                        </div>
                    </div>

                    <!-- Account Details -->
                    <div class="px-6 py-6 border-b border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Account details
                            </h3>
                            <button
                                v-if="isAdmin && !editing"
                                @click="editing = true"
                                class="text-xs text-blue-600 hover:text-blue-800 font-medium"
                            >
                                Edit
                            </button>
                        </div>

                        <!-- View mode -->
                        <div v-if="!editing" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <p class="text-xs text-gray-400 mb-1">Email</p>
                                <p class="text-sm font-medium text-gray-900">{{ user.email }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <p class="text-xs text-gray-400 mb-1">Phone</p>
                                <p class="text-sm font-medium text-gray-900">{{ user.phone || '—' }}</p>
                            </div>
                        </div>

                        <!-- Edit mode -->
                        <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs text-gray-400 mb-1 block">Email</label>
                                <input
                                    v-model="form.email"
                                    type="email"
                                    class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <p v-if="form.errors.email" class="text-xs text-red-500 mt-1">{{ form.errors.email }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 mb-1 block">Phone</label>
                                <input
                                    v-model="form.phone"
                                    type="text"
                                    class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <p v-if="form.errors.phone" class="text-xs text-red-500 mt-1">{{ form.errors.phone }}</p>
                            </div>
                            <div class="md:col-span-2 flex gap-2 justify-end">
                                <button
                                    @click="editing = false; form.reset()"
                                    class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg"
                                >
                                    Cancel
                                </button>
                                <button
                                    @click="submit"
                                    :disabled="form.processing"
                                    class="px-4 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-lg disabled:opacity-50"
                                >
                                    Save changes
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Linked Patients -->
                    <div class="px-6 py-6">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Linked patients
                            <span class="ml-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                {{ user.patients.length }}
                            </span>
                        </h3>

                        <div v-if="user.patients.length" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div
                                v-for="patient in user.patients"
                                :key="patient.id"
                                class="flex items-center gap-3 px-4 py-3 bg-white border border-gray-200 rounded-lg group hover:border-blue-200 transition-colors"
                            >
                                <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center flex-shrink-0 text-xs font-semibold text-sky-700">
                                    {{ initials(patient.name) }}
                                </div>
                                <Link :href="route('patients.show', patient.id)" class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate hover:text-blue-600 transition-colors">{{ patient.name }}</p>
                                    <p v-if="patient.birth_date" class="text-xs text-gray-400 mt-0.5">
                                        {{ new Date(patient.birth_date).toLocaleDateString() }}
                                    </p>
                                </Link>
                                <button
                                    v-if="isAdmin"
                                    @click="deletePatient(patient.id)"
                                    class="flex-shrink-0 p-1.5 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div v-else class="text-center py-8 text-gray-400 text-sm">
                            No patients linked to this account.
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                        <Link :href="route('users.index')" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                            ← Back to users
                        </Link>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
