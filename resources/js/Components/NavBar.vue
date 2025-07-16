<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    user: Object,
})
</script>

<template>
    <nav class="flex justify-between items-center px-8 py-4 shadow-md bg-white/80 dark:bg-gray-900/80 backdrop-blur-md">
        <h1 class="text-2xl font-bold text-sky-700 dark:text-sky-300">DentistClinic</h1>
        <div class="space-x-4">
            <Link
                v-if="canLogin && user"
                :href="route('dashboard')"
                class="text-sm px-4 py-2 rounded-md bg-sky-600 text-white hover:bg-sky-700 transition"
            >
                Dashboard
            </Link>
            <template v-else>
                <Link
                    v-if="canLogin"
                    :href="route('login')"
                    class="text-sm px-4 py-2 rounded-md bg-sky-600 text-white hover:bg-sky-700 transition"
                >
                    Login
                </Link>
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="text-sm px-4 py-2 rounded-md bg-white border border-sky-600 text-sky-600 hover:bg-sky-50 transition"
                >
                    Register
                </Link>
            </template>
        </div>
    </nav>
</template>
