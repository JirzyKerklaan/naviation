<script setup>
const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    content: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div class="px-6 py-4 w-full h-fit bg-backgroundlight rounded-lg">
        <span class="text-xl text-text font-bold" v-if="props.title">{{ props.title }}</span>
        <div class="mt-4 flex flex-row justify-between" v-if="props.content" v-html="props.content">
        </div>
    </div>
</template>