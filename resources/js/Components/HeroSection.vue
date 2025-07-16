<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
});
</script>

<template>
  <section class="flex-grow flex flex-col justify-center items-center text-center px-4">
    <h2 class="text-4xl md:text-5xl font-extrabold leading-tight text-gray-900 dark:text-white mb-6">
      Welcome to <span class="text-sky-600 dark:text-sky-400">Dentist Clinic</span>
    </h2>
    <p class="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mb-8">
      Manage appointments, patients, and doctors easily with our intuitive dashboard system.
    </p>
    <div class="flex gap-4">
        
      <Link
        v-if="canLogin"
        :href="route('login')"
         class="px-6 py-3 text-white bg-sky-600 hover:bg-sky-700 rounded-lg text-sm font-medium transition"
      >
        Login
      </Link>
      <Link
        v-if="canRegister"
        :href="route('register')"
         class="px-6 py-3 bg-white border border-sky-600 text-sky-600 hover:bg-sky-50 rounded-lg text-sm font-medium transition"
      >
        Get Started
      </Link>
    </div>
  </section>
</template>
