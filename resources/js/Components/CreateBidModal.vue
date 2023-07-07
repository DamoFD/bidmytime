<script setup>
import {useForm} from '@inertiajs/vue3'
import moment from 'moment';

const emit = defineEmits(['close'])

const props = defineProps({
    timeSlot: String,
    bids: Array,
    selectedDate: String,
    startTime: String,
    endTime: String,
    seller: Object,
    highestBidder: Object,
})

const formatTimeTo24Hour = (time) => {
    return moment(time, ["h:mm A"]).format("HH:mm:ss")
}

const form = useForm({
    amount: null,
    sellers_id: props.seller.id,
    date: props.selectedDate,
    startTime: formatTimeTo24Hour(props.startTime),
    endTime: formatTimeTo24Hour(props.endTime),
})

const submitBid = () => {
    form.post('/bids', {
        onSuccess: () => closeModal(),
    })
}

const closeModal = () => {
    form.reset()
    emit('close')
}

</script>

<template>
    <div class="fixed top-0 left-0 flex justify-center items-center w-full h-full bg-white bg-opacity-20 backdrop-blur-sm">
        <div class="flex flex-col relative bg-white rounded-md shadow-xl w-11/12 max-w-xl mt-14">
            <h2 class="font-nunito text-gray-900 font-extrabold pt-44 pl-2 text-lg">Top Bidder</h2>
            <div class="flex justify-between items-center shadow-lg mt-2 p-2 mx-2 rounded-md">
                <img :src="highestBidder.user.image" class="w-10 h-10 rounded-full" />
                <h3 class="font-inter text-gray-900">{{highestBidder.user.name}}</h3>
                <p class="font-nunito font-extrabold text-gray-900">${{highestBidder.amount.toFixed(2)}}</p>
            </div>
            <div class="overflow-y-auto mt-2 h-44">
                <div v-for="bid in bids" :key="bid.id" class="flex justify-between items-center p-2 mx-2 rounded-md">
                    <img :src="bid.user.image" class="w-10 h-10 rounded-full" />
                    <h3 class="font-inter text-gray-900">{{bid.user.name}}</h3>
                    <p class="font-nunito font-extrabold text-gray-900">${{bid.amount.toFixed(2)}}</p>
                </div>
            </div>
            <label class="font-nunito font-extrabold text-gray-900 pl-2 text-lg">
                Your Bid
            </label>
            <span class="border border-gray-200 mx-2 pl-2 font-inter text-gray-900">$
                <input class="mx-2 h-10 focus:ring-0 focus:outline-0" v-model="form.amount" placeholder="Enter your bid" />
            </span>
            <div class="mx-2 my-4 flex justify-between">
                <button class="bg-gradient-to-r from-[#02AABD] to-[#00CDAC] py-2 w-24 rounded-lg cursor-pointer text-white font-nunito font-extrabold" @click="submitBid">Bid</button>
                <button class="bg-gradient-to-r from-[#D4145A] to-[#FBB03B] py-2 w-24 rounded-lg cursor-pointer text-white font-nunito font-extrabold" @click="closeModal">Cancel</button>
            </div>
            <img :src="seller.image" class="absolute w-11/12 h-60 -top-20 left-1/2 -translate-x-1/2 rounded-md object-cover shadow-lg" />
        </div>
    </div>
<!--    <div class="fixed top-0 left-0 flex justify-center items-center w-full h-full bg-black bg-opacity-10">-->
<!--        <div class="flex flex-col items-center justify-center bg-white">-->
<!--            <img :src="seller.image" class="w-10 h-10 rounded-full" />-->
<!--            <h1 class="p-10">{{timeSlot}}</h1>-->
<!--            <h2>Top Bidder</h2>-->
<!--            <div class="flex justify-between items-center shadow-lg">-->
<!--                <img :src="highestBidder.user.image" class="w-10 h-10 rounded-full" />-->
<!--                <h3>{{highestBidder.user.name}}</h3>-->
<!--                <p>${{highestBidder.amount.toFixed(2)}}</p>-->
<!--            </div>-->
<!--            <div>-->
<!--                <input v-model="form.amount" type="text" placeholder="Enter your bid"/>-->

<!--                &lt;!&ndash; Errors &ndash;&gt;-->
<!--                <p v-if="form.errors.amount" class="text-red-600">{{ form.errors.amount}}</p>-->
<!--                <p v-if="form.errors.sellers_id" class="text-red-600">{{ form.errors.sellers_id}}</p>-->
<!--                <p v-if="form.errors.date" class="text-red-600">{{ form.errors.date }}</p>-->

<!--                <div class="flex justify-between w-full py-6">-->
<!--                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="submitBid()">Bid</button>-->
<!--                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" @click="closeModal()">Cancel</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</template>
