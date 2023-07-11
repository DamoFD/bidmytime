<script setup>
import {ref, computed, watch} from 'vue'
import {Link} from '@inertiajs/vue3'
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
            // Convert the start time and end time from utc to local timezone
            let startTime = moment.utc(time.start_time, 'HH:mm:ss').local()
            let endTime = moment.utc(time.end_time, 'HH:mm:ss').local()

            if (endTime.isBefore(startTime)) {
                endTime.add(1, 'days');
            }

            let duration = moment.duration(endTime.diff(startTime))

            // Add the start time (formatted) and end time (formatted) to the timeslots array
            timeslots.push({
                start: startTime.format('h:mm a'),
                end: endTime.format('h:mm a'),
                duration: duration.asMinutes()
            })
        })

        rawTimeSlots.value = attachHighestBidsToTimeSlots(timeslots, props.seller.bids, props.selectedDate)
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

//Slug Date
const slugDate= computed(() => {
    return moment(props.selectedDate).format('YYYY-MM-DD')
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

const attachHighestBidsToTimeSlots = (timeSlots, bids, selectedDate) => {
    return timeSlots.map(slot => {
        // Convert slot start and end times to moment objects for comparison
        let slotStart = moment(slot.start, 'h:mm a').format('HH:mm:ss');
        let slotEnd = moment(slot.end, 'h:mm a').format('HH:mm:ss');

        // Filter bids that fall into this slot
        let slotBids = bids.filter(bid => {
            let bidStart = moment.utc(bid.start_time, 'HH:mm:ss').local().format('HH:mm:ss');
            let bidEnd = moment.utc(bid.end_time, 'HH:mm:ss').local().format('HH:mm:ss');
            let bidDate = bid.bid_date;
            let slotDate = moment(selectedDate).format('YYYY-MM-DD');

            return bidStart === slotStart && bidEnd === slotEnd && bidDate === slotDate;
        });

        // Find the highest bid
        let highestBid = slotBids.reduce((highest, bid) => {
            return Math.max(highest, bid.amount);
        }, 0);

        // Add highest bid to slot object
        return {...slot, highestBid: highestBid.toFixed(2), totalBids: slotBids.length};
    });
}

//Convert Time to UTC 24 hour
const convertTimeToUTC = (time) => {
    return moment(`${formattedDate.value} ${time}`, 'MMMM Do, YYYY h:mm a').utc().format('HH:mm:ss')
}

</script>


<template>
    <!-- Main Wrapper -->
    <div class="flex flex-col w-full items-center">
        <h2 class="text-lg font-nunito font-black text-gray-900 md:text-xl">{{ formattedDate }}</h2>
        <p class="text-md font-inter text-gray-500 mb-4 md:text-lg">What time works best?</p>

        <!-- Time Slots -->
        <div class="flex flex-col items-center w-full p-4 overflow-y-auto h-80 md:h-96">
            <Link
                v-for="slot in timeSlots"
                :key="slot"
                class="border border-gray-300 w-full py-2 flex rounded-xl flex-col mb-2 cursor-pointer hover:bg-gray-100"
                :href="route('bids.show', { sellers_id: seller.id, bid_date: slugDate, start_time: convertTimeToUTC(slot.start), end_time: convertTimeToUTC(slot.end) })"
            >
                <div class="flex justify-between px-2">
                    <div>
                        <p class="font-inter text-gray-500 text-sm md:text-lg">Time Slot</p>
                        <h3 class="font-nunito text-gray-900 font-extrabold md:text-xl">{{ slot.start }} - {{ slot.end }}</h3>
                    </div>
                    <div>
                        <p class="font-inter text-gray-500 text-sm md:text-lg">Current Bid</p>
                        <h3 class="font-nunito text-gray-900 font-extrabold md:text-xl">${{ slot.highestBid }}</h3>
                    </div>
                </div>
                <div class="flex justify-between px-2">
                <div>
                    <p class="font-inter text-gray-500 text-sm mt-2 md:text-lg">Ending</p>
                    <p class="font-nunito text-gray-900 font-extrabold md:text-xl">{{ timeUntilBidEnds(slot) }}</p>
                </div>
                    <div>
                        <p class="font-inter text-gray-500 text-sm mt-2 md:text-lg">Total Bids</p>
                        <p class="font-nunito text-gray-900 font-extrabold md:text-xl">{{ slot.totalBids }}</p>
                    </div>
                </div>
                <p class="font-inter text-gray-500 text-sm mt-2 ml-2 md:text-lg">Duration</p>
                <p class="font-nunito text-gray-900 font-extrabold ml-2 md:text-xl">{{ slot.duration }} minutes</p>
                <div class="flex justify-center items-center mt-2">
                    <p class="bg-gradient-to-r from-[#02AABD] to-[#00CDAC] py-2 px-12 rounded-lg cursor-pointer text-white font-nunito font-extrabold md:text-xl">Bid</p>
                </div>
            </Link>
            <div v-if="timeSlots.length == 0" class="border border-gray-300 w-full py-2 rounded-xl bg-gray-100">
                <p class="text-center font-inter">No time slots available for this date</p>
            </div>
        </div>
    </div>
</template>
