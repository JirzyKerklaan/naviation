<script setup>
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head :title="props.title" />

    <div class="flex items-center py-8 bg-primary justify-center">
        <h1 class="text-3xl text-[#FEFEFE] font-bold tracking-wider uppercase" v-html="props.title"></h1>
    </div>
</template>
