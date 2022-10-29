<script setup>
defineProps({
    id: String,
    classes: String,
    accept: String,
    multiple: {
        type: Boolean,
        default: false,
    },
})
</script>
<template>
    <label class="block cursor-pointer">
        <span class="sr-only cursor-pointer">Choose File</span>
        <input type="file" :multiple="multiple" :accept="accept" :id="id"
            class="cursor-pointer block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-secondary file:text-primary hover:file:bg-secondary" />
    </label>
</template>
