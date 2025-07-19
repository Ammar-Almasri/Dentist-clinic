<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
});
</script>

<template>
  <section class="min-h-screen bg-gradient-to-br from-white to-blue-50 flex flex-col justify-center items-center text-center px-4 overflow-hidden relative">
    <!-- Decorative elements -->
    <div class="absolute -top-20 -right-20 w-64 h-64 bg-blue-100 rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-teal-100 rounded-full opacity-20 blur-3xl"></div>

    <!-- Animated tooth icon -->
    <div class="absolute top-1/4 left-1/4 w-16 h-16 opacity-10 animate-float">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-blue-500">
        <path d="M7 14C7 14 7.5 12 9 12C10.5 12 11 14 11 14M13 14C13 14 13.5 12 15 12C16.5 12 17 14 17 14M18 8C18 8 18.5 6 20 6M6 8C6 8 5.5 6 4 6M12 22C16.4183 22 20 18.4183 20 14V8C20 5.79086 18.2091 4 16 4H8C5.79086 4 4 5.79086 4 8V14C4 18.4183 7.58172 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>

    <!-- Main content -->
    <div class="relative z-10 max-w-4xl mx-auto">
      <!-- Animated headline -->
      <h2 class="text-5xl md:text-7xl font-extrabold leading-tight text-gray-900 mb-6 animate-fade-in">
        Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-teal-400">Smile</span> Matters
      </h2>

      <!-- Subheading with animated typing effect -->
      <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mb-10 leading-relaxed animate-fade-in [animation-delay:200ms]">
        Experience premium dental care with our state-of-the-art clinic management system
      </p>

      <!-- CTA buttons with hover effects -->
      <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in [animation-delay:400ms]">
        <Link
          v-if="canLogin"
          :href="route('login')"
          class="px-8 py-4 text-white bg-gradient-to-r from-blue-600 to-teal-500 hover:from-blue-700 hover:to-teal-600 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl flex items-center justify-center gap-2"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
          </svg>
          Login
        </Link>

        <Link
          v-if="canRegister"
          :href="route('register')"
          class="px-8 py-4 bg-white border-2 border-blue-500 text-blue-600 hover:bg-blue-50 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl flex items-center justify-center gap-2"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
          </svg>
          Register Now
        </Link>
      </div>

      <!-- Features grid -->
      <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mt-16 animate-fade-in [animation-delay:600ms]">
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all border border-gray-100">
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4 mx-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
          <h3 class="font-bold text-gray-800">Easy Scheduling</h3>
          <p class="text-gray-600 text-sm mt-1">Book appointments in seconds</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all border border-gray-100">
          <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mb-4 mx-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
          </div>
          <h3 class="font-bold text-gray-800">Patient Records</h3>
          <p class="text-gray-600 text-sm mt-1">Digital health history</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all border border-gray-100">
          <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4 mx-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>
          <h3 class="font-bold text-gray-800">Secure Data</h3>
          <p class="text-gray-600 text-sm mt-1">HIPAA compliant</p>
        </div>
      </div>
    </div>

    <!-- Floating decorative elements -->
    <div class="absolute bottom-20 right-20 w-12 h-12 opacity-30 animate-float [animation-delay:2s]">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-teal-500">
        <path d="M7 14C7 14 7.5 12 9 12C10.5 12 11 14 11 14M13 14C13 14 13.5 12 15 12C16.5 12 17 14 17 14M18 8C18 8 18.5 6 20 6M6 8C6 8 5.5 6 4 6M12 22C16.4183 22 20 18.4183 20 14V8C20 5.79086 18.2091 4 16 4H8C5.79086 4 4 5.79086 4 8V14C4 18.4183 7.58172 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
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
  animation: fade-in 1s ease-out forwards;
}

.animate-float {
  animation: float 6s ease-in-out infinite;
}
</style>
