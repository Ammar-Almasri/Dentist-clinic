<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { ref } from 'vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';

const showingNavigationDropdown = ref(false);
const showUserDropdown = ref(false);

// Proper logout function
const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <div class="min-h-screen bg-slate-50">
            <!-- Navigation -->
            <nav class="bg-white border-b border-slate-200 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')" class="flex items-center space-x-3">
                                    <div class="bg-blue-600 p-2 rounded-lg">
                                        <ApplicationLogo class="block h-6 w-auto fill-current text-white" />
                                    </div>
                                    <span class="text-xl font-bold text-slate-800 hidden md:block">MedCare</span>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-1 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="nav-link">
                                    <i class="fas fa-chart-line mr-2"></i> Dashboard
                                </NavLink>
                                <NavLink :href="route('doctors.index')" :active="route().current('doctors.*')" class="nav-link">
                                    <i class="fas fa-user-md mr-2"></i> Doctors
                                </NavLink>
                                <NavLink :href="route('patients.index')" :active="route().current('patients.*')" class="nav-link">
                                    <i class="fas fa-user-injured mr-2"></i> Patients
                                </NavLink>
                                <NavLink :href="route('appointments.index')" :active="route().current('appointments.*')" class="nav-link">
                                    <i class="fas fa-calendar-check mr-2"></i> Appointments
                                </NavLink>
                            </div>
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-700 bg-white hover:text-slate-900 focus:outline-none transition ease-in-out duration-150 user-menu-btn"
                                            >
                                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold mr-2">
                                                    {{ $page.props.auth.user.name.charAt(0) }}
                                                </div>
                                                {{ $page.props.auth.user.name }}
                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.show')" class="dropdown-item">
                                            <i class="fas fa-user-circle mr-2"></i> Profile
                                        </DropdownLink>
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Mobile menu button -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-500 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden mobile-nav"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')" class="mobile-nav-link">
                            <i class="fas fa-chart-line mr-3"></i> Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('doctors.index')" :active="route().current('doctors.*')" class="mobile-nav-link">
                            <i class="fas fa-user-md mr-3"></i> Doctors
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('patients.index')" :active="route().current('patients.*')" class="mobile-nav-link">
                            <i class="fas fa-user-injured mr-3"></i> Patients
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('appointments.index')" :active="route().current('appointments.*')" class="mobile-nav-link">
                            <i class="fas fa-calendar-check mr-3"></i> Appointments
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-4 pb-1 border-t border-slate-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-slate-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-slate-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" class="mobile-nav-link">
                                <i class="fas fa-user-circle mr-3"></i> Profile
                            </ResponsiveNavLink>
                            <form @submit.prevent="logout">
                                <ResponsiveNavLink as="button" class="mobile-nav-link">
                                    <i class="fas fa-sign-out-alt mr-3"></i> Log Out
                                </ResponsiveNavLink>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow-sm" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="py-6 px-4 sm:px-6 lg:px-8">
                <slot />
            </main>
        </div>
    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

:root {
    --primary: #2563eb;
    --primary-dark: #1d4ed8;
    --secondary: #0e7490;
    --accent: #ec4899;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --light: #f8fafc;
    --dark: #1e293b;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-500: #64748b;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --gray-900: #0f172a;
}

body {
    font-family: 'Inter', sans-serif;
}

.min-h-screen {
    min-height: 100vh;
}

.bg-slate-50 {
    background-color: #f8fafc;
}

.border-slate-200 {
    border-color: #e2e8f0;
}

.shadow-sm {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

/* Navigation Links */
.nav-link {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.25rem;
    border-radius: 0.5rem;
    margin: 0.25rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.nav-link:hover {
    background-color: #f1f5f9;
    color: #2563eb;
}

.nav-link.router-link-active {
    background-color: #eff6ff;
    color: #2563eb;
}

/* User Menu */
.user-menu-btn {
    border-radius: 0.5rem;
    transition: all 0.2s ease;
}

.user-menu-btn:hover {
    background-color: #f1f5f9;
}

/* Dropdown Items */
.dropdown-item {
    display: flex;
    align-items: center;
    padding: 0.5rem 1rem;
    color: #374151;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f3f4f6;
    color: #1f2937;
}

/* Mobile Navigation */
.mobile-nav {
    background-color: white;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.mobile-nav-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    color: #374151;
    transition: all 0.2s ease;
}

.mobile-nav-link:hover {
    background-color: #f9fafb;
    color: #2563eb;
}

.mobile-nav-link.router-link-active {
    background-color: #eff6ff;
    color: #2563eb;
}

/* Page Header */
.bg-white {
    background-color: white;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .px-4 {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .max-w-7xl {
        max-width: 100%;
    }
}
</style>
