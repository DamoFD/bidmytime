<script setup>
import {ref} from 'vue'
import Calendar from '@/Components/Calendar.vue'
import TimeSlots from '@/Components/TimeSlots.vue'

const selectedDate = ref(null)

const updateDate = (date) => {
    selectedDate.value = date
}

const props = defineProps({
    seller: Object,
})

const weekdays = ref(props.seller.available_weekdays)
const times = ref(props.seller.availableTimes)

</script>

<template>
    <!-- Main Wrapper -->
    <div class="min-h-screen w-full flex items-center justify-center bg-gray-300">
        <div class="flex w-full m-10 bg-white rounded-xl">
            <Calendar @update-date="updateDate" :seller="seller" />
            <TimeSlots :selected-date="selectedDate" />
        </div>
    </div>
</template>
