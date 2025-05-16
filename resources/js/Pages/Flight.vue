<script setup>
import { Head } from '@inertiajs/vue3';
import PageHeader from '@/Components/PageHeader/PageHeader.vue';
import Card from '@/Components/Card/Card.vue';
import TextCard from '@/Components/Card/TextCard.vue';

const props = defineProps({
  flight: {
    type: Array,
    required: true,
  },
});

const convertTime = (time) => {
    const date = new Date(time);
    const options = {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false,
    };
    return date.toLocaleTimeString('en-US', options);
}
</script>

<template>
  <div class="flex flex-col px-4 bg-background max-w-screen">
    <PageHeader :title="`Flight: #${props.flight.flight.number}`" />

    <div class="flex flex-row gap-4">
      <TextCard
        title="Departure:"
        :content="`
          <p>${props.flight.departure.airport}</p>
          <p>${convertTime(props.flight.departure.scheduled)}</p>
        `"
      />
      
      <TextCard
        title="Arrival:"
        :content="`
          <p>${props.flight.arrival.airport}</p>
          <p>${convertTime(props.flight.arrival.scheduled)}</p>
        `"
      />
    </div>

    
      <TextCard
        title="Flight details:"
        :content="`
          <div class='flex flex-col gap-2 w-full text-sm text-left'>
            <div class='flex justify-between'>
              <span class='font-semibold'>Flight Number:</span>
              <span>${props.flight.flight.iata}</span>
            </div>
            <div class='flex justify-between'>
              <span class='font-semibold'>Status:</span>
              <span>${props.flight.flight_status}</span>
            </div>
            <div class='flex justify-between'>
              <span class='font-semibold'>Airline:</span>
              <span>${props.flight.airline.name}</span>
            </div>
            <div class='flex justify-between'>
              <span class='font-semibold'>From:</span>
              <span>${props.flight.departure.airport} (${props.flight.departure.iata})</span>
            </div>
            <div class='flex justify-between'>
              <span class='font-semibold'>Departure:</span>
              <span>${convertTime(props.flight.departure.scheduled)}</span>
            </div>
            <div class='flex justify-between'>
              <span class='font-semibold'>To:</span>
              <span>${props.flight.arrival.airport} (${props.flight.arrival.iata})</span>
            </div>
            <div class='flex justify-between'>
              <span class='font-semibold'>Arrival:</span>
              <span>${convertTime(props.flight.arrival.scheduled)}</span>
            </div>
          </div>
        `" class="mt-4" />

        <a href="/" class="mt-4">
          <TextCard
            title="Return to overview"
            class="text-center"
          />
        </a>
  </div>
</template>
