<script setup>
import {ref, computed} from 'vue'
import moment from 'moment'

const props = defineProps([
    'selectedDate',
    'selectedWeekday'
])

let rawTimeSlots = ref(['9:00 am', '10:00 am', '11:00 am', '12:00 pm', '1:00 pm', '2:00 pm', '3:00 pm', '4:00 pm', '5:00 pm'])

//Format Date
const formattedDate = computed(() => {
    return moment(props.selectedDate).format('MMMM Do, YYYY')
})

// Filter the time slots based on their bid end time
let timeSlots = computed(() => {
    return rawTimeSlots.value.filter(slot => {
        // Calculate the bid end time for this slot
        let slotDateTime = moment(`${formattedDate.value} ${slot}`, 'MMMM Do, YYYY h:mm a');
        let bidEndTime = slotDateTime.clone().subtract(1, 'hours');

        // Include the slot only if its bid end time is in the future
        return bidEndTime.isAfter(moment());
    });
});

// Time until bid ends
const timeUntilBidEnds = (slot) => {

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
                class="border border-gray-300 w-full py-2 flex items-center justify-center rounded-xl flex-col mb-2 cursor-pointer hover:bg-gray-100"
            >
                <h3 class="font-inter">{{ slot }}</h3>
                <p class="font-inter">Bidding ends {{ timeUntilBidEnds(slot) }}</p>
                <p>12 Bids</p>
                <p>Current bid: $312.47</p>
            </div>
            <div v-if="timeSlots.length == 0" class="border border-gray-300 w-full py-2 rounded-xl bg-gray-100">
                <p class="text-center font-inter">No time slots available for this date</p>
            </div>
        </div>
    </div>
</template>
