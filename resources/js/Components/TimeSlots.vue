<script setup>
import {ref, computed, watch} from 'vue'
import moment from 'moment'
import useFilteredTimeSlots from "@/Composables/useFilteredTimeSlots.js";

const props = defineProps([
    'selectedDate',
    'selectedWeekday',
    'seller',
])

const timeSlotExceptions = ref(props.seller.available_exceptions)
const rawTimeSlots = ref([])

const setTimeSlots = () => {
    if (props.selectedWeekday) {
        const timeslots = []
        // Loop through each available time
        props.selectedWeekday.available_times.forEach(time => {
            // Parse the start time and end time using moment.js
            let startTime = moment(time.start_time, 'HH:mm:ss')
            let endTime = moment(time.end_time, 'HH:mm:ss')

            let duration = moment.duration(endTime.diff(startTime))

            // Add the start time (formatted) and end time (formatted) to the timeslots array
            timeslots.push({
                start: startTime.format('h:mm a'),
                end: endTime.format('h:mm a'),
                duration: duration.asMinutes()
            })
        })

        rawTimeSlots.value = timeslots
    }
}

watch(
    () => [props.selectedWeekday, props.selectedDate],
    () => {
        setTimeSlots()
    },
    { immediate: true }
)

//Format Date
const formattedDate = computed(() => {
    return moment(props.selectedDate).format('MMMM Do, YYYY')
})

// Filter the time slots based on their bid end time and exceptions
let timeSlots = useFilteredTimeSlots(rawTimeSlots, formattedDate, timeSlotExceptions)


// Time until bid ends
const timeUntilBidEnds = (slot) => {

    // Create moment object for the slot time on the selected date
    let slotDateTime = moment(`${formattedDate.value} ${slot.start}`, 'MMMM Do, YYYY h:mm a');

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
                <h3 class="font-inter">{{ slot.start }} - {{ slot.end }}</h3>
                <p class="font-inter">Bidding ends {{ timeUntilBidEnds(slot) }}</p>
                <p>12 Bids</p>
                <p>Current bid: $312.47</p>
                <p class="font-inter">{{ slot.duration }} minutes</p>
            </div>
            <div v-if="timeSlots.length == 0" class="border border-gray-300 w-full py-2 rounded-xl bg-gray-100">
                <p class="text-center font-inter">No time slots available for this date</p>
            </div>
        </div>
    </div>
</template>
