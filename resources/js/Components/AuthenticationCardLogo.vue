<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link :href="'/'">
        <div class="bg-blue-500 p-2 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M7 14C7 14 7.5 12 9 12C10.5 12 11 14 11 14M13 14C13 14 13.5 12 15 12C16.5 12 17 14 17 14M18 8C18 8 18.5 6 20 6M6 8C6 8 5.5 6 4 6M12 22C16.4183 22 20 18.4183 20 14V8C20 5.79086 18.2091 4 16 4H8C5.79086 4 4 5.79086 4 8V14C4 18.4183 7.58172 22 12 22Z"/>
            </svg>
        </div>
    </Link>
</template>
