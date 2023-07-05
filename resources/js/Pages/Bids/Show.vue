<script setup>
import moment from 'moment'
import {computed, ref} from "vue";
import CreateBidModal from "@/Components/CreateBidModal.vue";

const props = defineProps({
    bids: Array,
    selectedDate: String,
    startTime: String,
    endTime: String,
})

const sellerName = props.bids[0].seller.name
const totalBids = props.bids.length
let showCreateBidModal = ref(false)

// format dates
const formatCreatedAt = (date) => {
    return moment(date).format('MMMM Do, YYYY [at] hh:mm a')
}

// format timeslot
const formattedTimeslot = computed(() => {
    const startDate = moment(`${props.selectedDate} ${props.startTime}`, 'YYYY-MM-DD h:mm a')
    const endDate = moment(`${props.selectedDate} ${props.endTime}`, 'YYYY-MM-DD h:mm a')
    return `${startDate.format('MMMM Do, YYYY h:mm a')} - ${endDate.format('h:mm a')}`
})

// Find the highest bid
let highestBid = props.bids.reduce((highest, bid) => {
    return Math.max(highest, bid.amount);
}, 0);

</script>

<template>
    <div class="w-full min-h-screen bg-gray-300 flex justify-center items-center">
        <div class="w-full bg-white rounded-lg shadow-lg p-4 flex-col items-center flex mx-10">
        <h1>Bid on this time slot</h1>
            <p>Timeslot: {{formattedTimeslot}}</p>
        <h2>{{sellerName}}</h2>
        <p>This is your time slot description</p>
        <p>Time left: 1 Hour</p>
        <p>Previous bids:</p>
        <div v-for="bid in bids" :key="bid.id">
            <p>{{ bid.user_id }}: ${{ bid.amount }}</p>
            <p>{{formatCreatedAt(bid.created_at)}}</p>
        </div>
            <div class="w-1/2 bg-neutral-700 rounded-lg flex justify-between items-center shadow-lg">
                <div class="text-gray-200 p-6">
                    <p class="pb-2">Highest Bid</p>
                    <p>${{highestBid}} [{{totalBids}} bids]</p>
                </div>
                <p @click="showCreateBidModal = true" class="text-neutral-700 bg-yellow-200 p-2 mr-6 rounded-lg cursor-pointer">Place a Bid</p>
            </div>
        </div>
    </div>
    <CreateBidModal :timeSlot="formattedTimeslot" v-if="showCreateBidModal" @close="showCreateBidModal = false" />
</template>
