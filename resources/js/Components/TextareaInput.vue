<script setup>
defineProps({
    id: String,
    modelValue: String,
    rows: {
        type: [String, Number],
        default: 3
    },
    placeholder: String,
    class: String
});

defineEmits(['update:modelValue']);
</script>

<template>
    <textarea
        :id="id"
        :rows="rows"
        class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500 transition duration-200"
        :class="class"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :placeholder="placeholder"
    />
</template>
