<script setup>
import moment from 'moment'
import {computed, ref} from "vue"
import {Link} from '@inertiajs/vue3'
import CreateBidModal from "@/Components/CreateBidModal.vue"
import Back from "~icons/ion/chevron-back-outline"
import HeartOutline from "~icons/ph/heart"
import HeartFilled from "~icons/ph/heart-fill"

const props = defineProps({
    bids: Array,
    selectedDate: String,
    startTime: String,
    endTime: String,
    seller: Object,
})

const saved = ref(false)

const totalBids = props.bids.length
let showCreateBidModal = ref(false)

// format dates
const formatCreatedAt = (date) => {
    return moment(date).format('MMMM Do, YYYY [at] hh:mm a')
}

// format timeslot
const formattedTimeslot = computed(() => {
    const startDate = moment.utc(`${props.selectedDate} ${props.startTime}`, 'YYYY-MM-DD h:mm a').local()
    const endDate = moment.utc(`${props.selectedDate} ${props.endTime}`, 'YYYY-MM-DD h:mm a').local()
    return `${startDate.format('MMMM Do, YYYY h:mm a')} - ${endDate.format('h:mm a')}`
})

// Find the highest bid
let highestBidder = props.bids.reduce((highest, bid) => {
    return (bid.amount > highest.amount)? bid : highest
}, {amount: 0});

</script>

<template>
    <!-- Hero -->
    <div class="w-full flex flex-col items-center relative overflow-hidden pb-10">
        <div class="flex justify-between items-center w-full mt-10">
            <Link :href="route('sellers.show', seller.id)" class="flex justify-center items-center bg-white bg-opacity-50 rounded-full w-8 h-8 ml-4 md:ml-10 md:w-10 md:h-10">
                <Back />
            </Link>
                <h1 class="font-nunito font-extrabold text-xl text-gray-900 md:text-2xl">{{seller.name}}</h1>
            <div @click="saved = !saved" class="flex justify-center items-center bg-white bg-opacity-50 rounded-full w-8 h-8 cursor-pointer mr-4 md:mr-10 md:w-10 md:h-10">
                <HeartOutline v-if="saved === false" />
                <HeartFilled v-else color="red" />
            </div>
        </div>
        <img class="max-w-5/6 max-h-80 mt-10" :src="seller.image" />
        <div class="absolute h-full w-full bg-neutral-300 opacity-40 -z-[1]"></div>
        <img class="absolute h-full w-full object-cover blur-lg scale-[1.1] -z-[2]" :src="seller.image" />
    </div>

    <!-- Seller Info -->
    <div class="w-full flex flex-col">
        <h2 class="font-nunito font-extrabold text-lg ml-4 my-4 md:ml-10 md:text-2xl lg:ml-32">{{formattedTimeslot}}</h2>
        <div class="flex w-full justify-between items-center">
            <div class="flex flex-col pl-4 md:pl-10 lg:pl-32">
                <p class="text-sm font-inter text-gray-500 md:text-lg">Service</p>
                <p class="text-md font-nunito font-extrabold text-gray-900 md:text-xl">{{seller.service}}</p>
            </div>
            <div class="flex flex-col pr-4 md:pr-10 lg:pr-32">
                <p class="text-sm font-inter text-gray-500 md:text-lg">Ending in</p>
                <p class="text-md font-nunito font-extrabold text-gray-900 md:text-xl">3 hours</p>
            </div>
        </div>
        <p class="pl-4 mt-4 text-gray-500 font-inter text-sm md:pl-10 md:text-lg lg:pl-32">Creator</p>
        <p class="px-4 font-nunito font-extrabold text-gray-900 md:pl-10 md:text-xl lg:pl-32">{{seller.name}}</p>
        <p class="pl-4 mt-4 text-gray-900 font-nunito font-extrabold md:pl-10 md:text-xl lg:pl-32">Description</p>
        <p class="px-4 font-inter text-gray-500 md:px-10 md:text-xl lg:px-32">{{seller.bio}}</p>

        <!-- Place Bid -->
        <div class="w-full flex justify-center items-center py-6">
            <div class="w-11/12 lg:w-1/2 bg-gray-100 rounded-lg flex justify-between items-center shadow-lg">
                <div class="text-gray-200 p-6">
                    <p class="text-gray-700 font-inter text-sm md:text-lg">Highest Bid</p>
                    <p class="text-gray-900 font-nunito font-extrabold md:text-xl">${{highestBidder.amount.toFixed(2)}} [{{totalBids}} bids]</p>
                </div>
                <p @click="showCreateBidModal = true" class="bg-gradient-to-r from-[#02AABD] to-[#00CDAC] py-2 px-6 mr-6 rounded-lg cursor-pointer text-white font-nunito font-extrabold md:text-xl">Place a Bid</p>
            </div>
        </div>
    </div>
<!--    <div class="w-full min-h-screen bg-gray-300 flex justify-center items-center">-->
<!--        <div class="w-full bg-white rounded-lg shadow-lg p-4 flex-col items-center flex mx-10">-->
<!--        <h1>Bid on this time slot</h1>-->
<!--            <img :src="seller.image" class="rounded-full w-20 h-20" :alt="seller.name + '\'s image'" />-->
<!--            <h2>{{seller.name}}</h2>-->
<!--            <p>{{seller.bio}}</p>-->
<!--            <p>Timeslot: {{formattedTimeslot}}</p>-->
<!--        <p>This is your time slot description</p>-->
<!--        <p>Time left: 1 Hour</p>-->
<!--        <p>Previous bids:</p>-->
<!--        <div v-if="bids.length !== 0" v-for="bid in bids" :key="bid.id">-->
<!--            <img :src="bid.user.image" class="rounded-full" />-->
<!--            <p>{{ bid.user.name }}: ${{ bid.amount }}</p>-->
<!--            <p>{{formatCreatedAt(bid.created_at)}}</p>-->
<!--        </div>-->
<!--            <div v-else>-->
<!--                <p>Be the first to bid!</p>-->
<!--            </div>-->
<!--            <div class="w-1/2 bg-neutral-700 rounded-lg flex justify-between items-center shadow-lg">-->
<!--                <div class="text-gray-200 p-6">-->
<!--                    <p class="pb-2">Highest Bid</p>-->
<!--                    <p>${{highestBidder.amount}} [{{totalBids}} bids]</p>-->
<!--                </div>-->
<!--                <p @click="showCreateBidModal = true" class="text-neutral-700 bg-yellow-200 p-2 mr-6 rounded-lg cursor-pointer">Place a Bid</p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <CreateBidModal
        :timeSlot="formattedTimeslot"
        :bids="bids"
        :selectedDate="selectedDate"
        :startTime="startTime"
        :endTime="endTime"
        :seller="seller"
        :highestBidder="highestBidder"
        v-if="showCreateBidModal"
        @close="showCreateBidModal = false"
    />
</template>
