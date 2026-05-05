<script setup>
import { i18nState, toggleLocale } from '@/i18n';
</script>

<template>
    <button
        type="button"
        class="fixed bottom-4 right-4 z-50 inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-lg transition hover:border-blue-300 hover:text-blue-700 rtl:right-auto rtl:left-4"
        :aria-label="i18nState.locale === 'ar' ? 'Switch to English' : 'التبديل إلى العربية'"
        :title="i18nState.locale === 'ar' ? 'English' : 'العربية'"
        @click="toggleLocale"
    >
        <i class="fas fa-language"></i>
        <span>{{ i18nState.locale === 'ar' ? 'English' : 'العربية' }}</span>
    </button>
</template>
