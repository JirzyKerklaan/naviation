<script setup>
import { Head } from '@inertiajs/vue3';
import PageHeader from '@/Components/PageHeader/PageHeader.vue';
import Card from '@/Components/Card/Card.vue';

defineProps({
  flights: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <div class="flex flex-col px-4 bg-background max-w-screen">
    <PageHeader title="FLIGHTS" />

    <div class="flex flex-col gap-4">
      <Card
        v-for="(flight, index) in flights"
        :key="flight.id || index"
        :flight="flight"
      />
    </div>
  </div>
</template>
