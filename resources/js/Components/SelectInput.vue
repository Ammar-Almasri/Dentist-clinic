<template>
    <select
        :id="id"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        :class="{ 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500': error }"
    >
        <slot />
    </select>
</template>

<script setup>
defineProps({
    id: {
        type: String,
        required: false,
    },
    modelValue: {
        type: [String, Number, Boolean, Array],
        required: true,
    },
    error: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['update:modelValue']);
</script>
