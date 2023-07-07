<script setup>
import {ref, computed} from 'vue'
import {Link} from "@inertiajs/vue3";
import Back from "~icons/ion/chevron-back-outline"
import HeartOutline from "~icons/ph/heart"
import HeartFilled from "~icons/ph/heart-fill"
import Calendar from '@/Components/Calendar.vue'
import TimeSlots from '@/Components/TimeSlots.vue'

const selectedDate = ref(null)
const selectedWeekdayId = ref(null)
const saved = ref(false)

const updateDate = (date, weekdayId) => {
    selectedDate.value = date
    selectedWeekdayId.value = weekdayId
}

const props = defineProps({
    seller: Object,
})

const weekdays = ref(props.seller.available_weekdays)

const selectedWeekday = computed(() => {
    return weekdays.value.find(weekday => weekday.id === selectedWeekdayId.value)
})

</script>

<template>
    <!-- Hero -->
    <div class="w-full flex flex-col items-center relative overflow-hidden pb-10">
        <div class="flex justify-between items-center w-full mt-10">
            <Link :href="route('sellers.index')" class="flex justify-center items-center bg-white bg-opacity-50 rounded-full w-8 h-8 ml-4 md:ml-10 md:w-10 md:h-10">
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
        <h2 class="font-nunito font-extrabold text-lg ml-4 my-4 md:ml-10 md:text-2xl lg:ml-32">{{seller.name}}</h2>
        <div class="flex flex-col pl-4 md:pl-10 lg:pl-32">
            <p class="text-sm font-inter text-gray-500 md:text-lg">Service</p>
            <p class="text-md font-nunito font-extrabold text-gray-900 md:text-xl">{{seller.service}}</p>
        </div>
    </div>

    <!-- Time Slots -->
    <div class="w-full flex justify-center">
        <div class="flex flex-col w-full mt-4 items-center md:flex-row md:mb-20 lg:w-1/2">
            <Calendar @update-date="updateDate" :seller="seller" />
            <div class="w-full md:w-2/3 px-4 mt-4">
                <TimeSlots :selected-date="selectedDate" :selected-weekday="selectedWeekday" :seller="seller" />
            </div>
        </div>
    </div>
</template>
