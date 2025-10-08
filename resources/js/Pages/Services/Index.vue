<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  services: Array
});
</script>

<template>
  <section class="min-h-screen bg-gradient-to-br from-white to-blue-50 py-12 px-4 sm:px-6 lg:px-8 overflow-hidden relative">
    <!-- Decorative elements -->
    <div class="absolute -top-20 -right-20 w-64 h-64 bg-blue-100 rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-teal-100 rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute top-1/3 right-10 w-24 h-24 bg-purple-100 rounded-full opacity-20 blur-3xl"></div>

    <!-- Animated tooth icons -->
    <div class="absolute top-1/4 left-1/4 w-16 h-16 opacity-10 animate-float">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-blue-500">
        <path d="M7 14C7 14 7.5 12 9 12C10.5 12 11 14 11 14M13 14C13 14 13.5 12 15 12C16.5 12 17 14 17 14M18 8C18 8 18.5 6 20 6M6 8C6 8 5.5 6 4 6M12 22C16.4183 22 20 18.4183 20 14V8C20 5.79086 18.2091 4 16 4H8C5.79086 4 4 5.79086 4 8V14C4 18.4183 7.58172 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>

    <!-- Main container -->
    <div class="relative z-10 max-w-7xl mx-auto">
      <!-- Header section -->
      <div class="text-center mb-16 animate-fade-in">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
          Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-teal-400">Dental Services</span>
        </h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Premium dental care tailored to your needs
        </p>
      </div>

      <!-- Services grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 animate-fade-in [animation-delay:200ms]">
        <div
          v-for="service in services"
          :key="service.id"
          class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100"
        >
          <!-- Card content -->
          <div class="p-8 flex flex-col h-full">
            <!-- Service name with decorative icon -->
            <div class="flex items-start mb-6">
              <div class="bg-blue-100 p-3 rounded-lg mr-4 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-gray-800 leading-tight">
                {{ service.name }}
              </h3>
            </div>

            <!-- Price and duration -->
            <div class="flex justify-between items-center mb-8 px-2">
              <div class="text-center">
                <p class="text-sm text-gray-500 mb-1">Price</p>
                <p class="text-xl font-semibold text-blue-600">{{ service.price }}</p>
              </div>
              <div class="h-12 w-px bg-gray-200"></div>
              <div class="text-center">
                <p class="text-sm text-gray-500 mb-1">Duration</p>
                <p class="text-xl font-semibold text-teal-600">{{ service.duration }}</p>
              </div>
            </div>

            <Link
            :href="route('services.show', service.id)"
            class="mt-auto w-full py-3 px-6 bg-gradient-to-r from-blue-500 to-teal-400 text-white font-medium rounded-lg transition-all duration-300 transform flex items-center justify-center space-x-2 pointer-events-none opacity-60"
            >
            <span>View Service</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            </Link>
          </div>
        </div>
      </div>

      <!-- Back to home link -->
      <div class="text-center mt-16 animate-fade-in [animation-delay:400ms]">
        <Link
          href="/"
          class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-300 shadow-sm"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
          </svg>
          Back to Home
        </Link>
      </div>
    </div>
  </section>
</template>

<style>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes float {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-20px);
  }
}

.animate-fade-in {
  animation: fade-in 0.8s ease-out forwards;
}

.animate-float {
  animation: float 6s ease-in-out infinite;
}
</style>
