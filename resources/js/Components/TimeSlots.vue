<script setup>
import {ref, computed} from 'vue'
import moment from 'moment'

const props = defineProps(['selectedDate'])
let timeSlots = ref(['9:00 am', '10:00 am', '11:00 am', '12:00 pm', '1:00 pm', '2:00 pm', '3:00 pm', '4:00 pm', '5:00 pm'])

//Format Date
const formattedDate = computed(() => {
    return moment(props.selectedDate).format('MMMM Do, YYYY')
})

// Time until bid ends
const timeUntilBidEnds = (slot) => {
    // Create moment object for the selected date
    let selectedDateTime = moment(props.selectedDate);

    // Create moment object for the slot time on the selected date
    let slotDateTime = moment(`${formattedDate.value} ${slot}`, 'MMMM Do, YYYY h:mm a');

    // Calculate the bid end time
    let bidEndTime = slotDateTime.clone().subtract(1, 'hours');

    // Calculate the time until the bid ends
    let duration = moment.duration(bidEndTime.diff(moment()));

    // Return the time until the bid ends, humanized
    return duration.humanize(true);
}


</script>

<template>
    <!-- Main Wrapper -->
    <div class="flex flex-col justify-center items-center w-1/2">
        <h2 class="text-xl font-nunito font-black text-gray-700">{{ formattedDate }}</h2>
        <p class="text-md font-inter">What time works best?</p>

        <!-- Time Slots -->
        <div class="flex flex-col items-center w-full p-4">
            <div
                v-for="slot in timeSlots"
                :key="slot"
                class="border border-gray-300 w-full h-10 flex items-center justify-center rounded-xl"
            >
                <h3 class="font-inter">{{ slot }}</h3>
                <p>{{ timeUntilBidEnds(slot) }}</p>
            </div>
        </div>
    </div>
</template>
