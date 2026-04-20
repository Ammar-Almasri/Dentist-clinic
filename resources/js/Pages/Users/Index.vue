<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, computed, watch } from 'vue';
import { Roles } from '@/Constants/Roles';

const props = defineProps({
    users: Object,
    auth: Object,
    filters: Object,
});

const searchName = ref(props.filters.name || '');
const searchEmail = ref(props.filters.email || '');

const isAdmin = computed(() => {
    return props.auth?.user?.role_id === Roles.ADMIN || props.auth?.user?.role_id === Roles.SUPER_ADMIN || props.auth?.user?.role_id === Roles.SUPER_ADMIN;
});

const getRoleLabel = (roleId) => {
    const labels = {
        [Roles.ADMIN]: 'Admin',
        [Roles.DOCTOR]: 'Doctor',
        [Roles.SUPER_ADMIN]: 'SUPER ADMIN',
    };
    return labels[roleId] || 'User';
};

const deleteUser = (userId) => {
    if (confirm('Are you sure you want to delete this user?')) {
        router.delete(route('users.destroy', userId));
    }
};

const getRoleBadgeClass = (roleId) => {
    const classes = {
        [Roles.ADMIN]: 'bg-purple-50 text-purple-700',
        [Roles.DOCTOR]: 'bg-blue-50 text-blue-700',
        [Roles.SUPER_ADMIN]: 'bg-teal-50 text-teal-700',
    };
    return classes[roleId] || 'bg-gray-50 text-gray-700';
};

watch([searchName, searchEmail], ([name, email]) => {
    router.get(route('users.index'), {
        name: name || null,
        email: email || null,
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
}, { deep: true });

const resetFilters = () => {
    searchName.value = '';
    searchEmail.value = '';
    router.get(route('users.index'), {}, {
        preserveState: true,
        preserveScroll: true,
    });
};

const goToPage = (url) => {
    if (url) {
        const parsedUrl = new URL(url, window.location.origin);
        const relativePathWithQuery = parsedUrl.pathname + parsedUrl.search;

        router.get(relativePathWithQuery, {
            name: searchName.value || null,
            email: searchEmail.value || null,
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">User Management</h2>
                    <p class="mt-2 text-gray-600">Manage and view system users</p>
                </div>
                <div class="flex items-center gap-4">
                    <Link :href="route('dashboard')" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back to Dashboard
                    </Link>
                    <Link v-if="isAdmin" :href="route('users.create')">
                        <PrimaryButton class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                            Add New User
                        </PrimaryButton>
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Filters Section -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-200">
                    <div class="flex flex-col md:flex-row gap-4 items-end">
                        <!-- Name Search -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input
                                    v-model="searchName"
                                    type="text"
                                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Search by name..."
                                />
                            </div>
                        </div>

                        <!-- Email Search -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input
                                    v-model="searchEmail"
                                    type="text"
                                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Search by email..."
                                />
                            </div>
                        </div>

                        <!-- Reset Button -->
                        <div class="w-full md:w-auto">
                            <button
                                @click="resetFilters"
                                class="w-full md:w-auto px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-200 border border-gray-300"
                                :class="{ 'opacity-50': !searchName && !searchEmail }"
                                :disabled="!searchName && !searchEmail"
                            >
                                Reset
                            </button>
                        </div>
                    </div>

                    <!-- Results Count -->
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-600">
                            Showing {{ users.from }} to {{ users.to }} of {{ users.total }} users
                        </p>
                    </div>
                </div>

                <!-- Users Grid -->
                <div v-if="users.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <div
                        v-for="user in users.data"
                        :key="user.id"
                        class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 hover:border-blue-200 group"
                    >
                        <div class="p-6">
                            <!-- User Avatar -->
                            <div class="flex justify-center mb-5">
                                <div class="relative">
                                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-50 via-blue-100 to-teal-50 flex items-center justify-center overflow-hidden border-2 border-blue-100">
                                        <span class="text-2xl font-bold text-blue-600">
                                            {{ user.name.charAt(0).toUpperCase() }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- User Info -->
                            <div class="text-center">
                                <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-blue-700 transition-colors">{{ user.name }}</h3>

                                <!-- Role Badge -->
                                <div class="flex justify-center mb-2">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                        :class="getRoleBadgeClass(user.role_id)"
                                    >
                                        {{ getRoleLabel(user.role_id) }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-center text-xs text-gray-600 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ user.email }}
                                </div>

                                <div class="flex items-center justify-center text-xs text-gray-500 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ user.phone || 'No phone number' }}
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-center space-x-3 mt-5">
                                <Link
                                    :href="route('users.show', user.id)"
                                    class="flex items-center justify-center px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors duration-200 text-sm font-medium"
                                    title="View Details"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View
                                </Link>
                                <button
                                    v-if="isAdmin"
                                    @click="deleteUser(user.id)"
                                    class="flex items-center justify-center px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors duration-200 text-sm font-medium"
                                    title="Delete User"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="bg-white rounded-xl shadow-sm p-12 text-center border border-gray-200">
                    <div class="max-w-md mx-auto">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No users found</h3>
                        <p class="text-gray-500 mb-6">
                            Try adjusting your search criteria or browse all available users.
                        </p>
                        <button
                            @click="resetFilters"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset filters
                        </button>
                    </div>
                </div>

                <!-- Pagination Controls -->
                <div v-if="users.last_page > 1" class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-700">
                            Showing {{ users.from }} to {{ users.to }} of {{ users.total }} results
                        </div>

                        <div class="flex items-center space-x-2">
                            <button
                                @click="goToPage(users.prev_page_url)"
                                :disabled="!users.prev_page_url"
                                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Previous
                            </button>

                            <div class="hidden sm:flex space-x-1">
                                <template v-for="(link, index) in users.links" :key="index">
                                    <button
                                        v-if="link.label !== '&laquo; Previous' && link.label !== 'Next &raquo;'"
                                        @click="goToPage(link.url)"
                                        :disabled="!link.url"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium border rounded-md transition-colors"
                                        :class="{
                                            'bg-blue-600 border-blue-600 text-white': link.active,
                                            'text-gray-500 bg-white border-gray-300 hover:bg-gray-50': !link.active && link.url,
                                            'text-gray-300 bg-gray-100 border-gray-300 cursor-not-allowed': !link.url
                                        }"
                                        v-html="link.label"
                                    ></button>
                                </template>
                            </div>

                            <button
                                @click="goToPage(users.next_page_url)"
                                :disabled="!users.next_page_url"
                                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                Next
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
