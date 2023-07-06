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

console.log(formatTimeTo24Hour(props.endTime))

</script>

<template>
    <div class="fixed top-0 left-0 flex justify-center items-center w-full h-full bg-black bg-opacity-10">
        <div class="flex flex-col items-center justify-center bg-white">
            <img :src="seller.image" class="w-10 h-10 rounded-full" />
            <h1 class="p-10">{{timeSlot}}</h1>
            <h2>Top Bidder</h2>
            <div class="flex justify-between items-center shadow-lg">
                <img :src="highestBidder.user.image" class="w-10 h-10 rounded-full" />
                <h3>{{highestBidder.user.name}}</h3>
                <p>${{highestBidder.amount}}</p>
            </div>
            <div>
                <input v-model="form.amount" type="text" placeholder="Enter your bid"/>
                <p v-if="form.errors.amount" class="text-red-600">{{ form.errors.amount}}</p>
                <div class="flex justify-between w-full py-6">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="submitBid()">Bid</button>
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" @click="closeModal()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</template>
