<script setup>
import { defineProps, ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    flight: {
        type: Object,
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
  return date.toLocaleTimeString(undefined, options);
}


const flightProgress = ref('0%');

let interval;
onMounted(() => {
  interval = setInterval(() => {
    if (!props.flight?.departure?.scheduled || !props.flight?.arrival?.scheduled) {
      flightProgress.value = '0%';
      return;
    }

    const departureTime = new Date(props.flight.departure.scheduled);
    const arrivalTime = new Date(props.flight.arrival.scheduled);
    const currentTime = new Date();

    if (currentTime < departureTime) {
      flightProgress.value = '0%';
    } else if (currentTime > arrivalTime) {
      flightProgress.value = '100%';
    } else {
      const totalDuration = arrivalTime - departureTime;
      const elapsedDuration = currentTime - departureTime;
      const percentage = (elapsedDuration / totalDuration) * 100;
      flightProgress.value = `${percentage.toFixed(1)}%`;
    }
  }, 1000);
});

onUnmounted(() => {
  clearInterval(interval);
});
</script>

<template>
    <a :href="`/${props.flight.flight.number}`" v-if="props.flight.flight.number" class="px-6 py-4 w-full h-fit bg-backgroundlight rounded-lg flex flex-col gap-2">
        <div class="flex flex-row w-full justify-between items-center">
            <div class="w-1/3 flex flex-col align-center justify-start"> 
                <span class="text-3xl uppercase text-text font-black" v-if="flight.departure.iata">{{flight.departure.iata}}</span>
                <span class="text-sm capitalize text-textlight font-medium" v-if="flight.departure.airport">{{flight.departure.airport}}</span>
            </div>
            <div class="w-1/3 flex align-center justify-center text-background">
                <img src="/svg/arrow.svg" alt="Arrow" class="w-7">
            </div>
            <div class="w-1/3 flex flex-col align-center justify-end text-right"> 
                <span class="text-3xl uppercase text-text font-black" v-if="flight.arrival.iata">{{flight.arrival.iata}}</span>
                <span class="text-sm capitalize text-textlight font-medium" v-if="flight.arrival.airport">{{flight.arrival.airport}}</span>
            </div>
        </div>
        <div class="flex flex-row w-full justify-between items-center">
            <div class="w-12 mr-6 flex flex-col align-center justify-start"> 
                <span class="text-xl uppercase text-text font-semibold" v-if="flight.departure.scheduled">{{convertTime(flight.departure.scheduled)}}</span>
            </div>
            <div class="w-full bg-background/25 h-1.5 rounded-full">
                <div
                    class="bg-background h-1 rounded-full"
                    :style="{ width: flightProgress }"
                ></div>
            </div>

            <div class="w-12 ml-6 flex flex-col align-center justify-end text-right"> 
                <span class="text-xl uppercase text-text font-semibold" v-if="flight.arrival.scheduled">{{convertTime(flight.arrival.scheduled)}}</span>
            </div>
        </div>
    </a>
</template>