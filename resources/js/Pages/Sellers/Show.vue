<script setup>
import {ref, computed} from 'vue'
import Calendar from '@/Components/Calendar.vue'
import TimeSlots from '@/Components/TimeSlots.vue'

const selectedDate = ref(null)
const selectedWeekdayId = ref(null)

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
    <!-- Main Wrapper -->
    <div class="min-h-screen w-full flex items-center justify-center bg-gray-300">
        <div class="flex w-full m-10 bg-white rounded-xl">
            <Calendar @update-date="updateDate" :seller="seller" />
            <TimeSlots :selected-date="selectedDate" :selected-weekday="selectedWeekday" />
        </div>
    </div>
</template>
