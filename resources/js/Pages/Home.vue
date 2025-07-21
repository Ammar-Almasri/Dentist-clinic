<script setup>
import { Head } from '@inertiajs/vue3';

import NavBar from '@/Components/NavBar.vue';
import HeroSection from '@/Components/HeroSection.vue';
import Footer from '@/Components/Footer.vue';
import BackgroundWrapper from '@/Components/BackgroundWrapper.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    services: Array,
});
</script>

<template>
    <Head title="Home" />
    <BackgroundWrapper>

        <!-- Hero Section -->
        <HeroSection
            :can-login="canLogin"
            :can-register="canRegister"
        />

        <!-- You can add FeatureCards here if you want to showcase features -->

        <!-- Footer -->
        <Footer
            :laravel-version="laravelVersion"
            :php-version="phpVersion"
            :services="services"
        />
    </BackgroundWrapper>
</template>
