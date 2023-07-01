<script setup>
import {ref, defineEmits, onMounted, computed} from 'vue'
import {DatePicker} from 'v-calendar'
import 'v-calendar/style.css'

const date = ref(new Date())
const props = defineProps({
    seller: Object
})
const weekdays = ref(props.seller.available_weekdays)

// Get an array of the available weekdays
const availableDaysOfWeek = computed(() => {
    return weekdays.value.map(weekday => weekday.day_of_week)
})

//List of disabled dates
const disabledDates = computed(() => {
    // Full list of all days in week
    const allDaysOfWeek= [1, 2, 3, 4, 5, 6, 7]

    //Calculate the disabled days by removing available days
    const disabledDaysOfWeek = allDaysOfWeek.filter(day => !availableDaysOfWeek.value.includes(day))

    // Return the disabled days in required format
    return [
        {
            repeat: {
                weekdays: disabledDaysOfWeek,
            }
        }
    ]
})

console.log(disabledDates.value)

//Emit current date on mount
onMounted(() => {
    updateDate(date.value)
})

const emit = defineEmits(['update-date'])

//Emit date to parent
const updateDate = (date) => {
    emit('update-date', date)
}
</script>

<template>
    <!-- Main Wrapper -->
    <div class="flex flex-col items-center w-1/2 py-10">
        <h1 class="text-2xl font-nunito font-black text-gray-800">{{ seller.name }}</h1>
        <p class="font-inter">Select a date and bid on your desired time slot!</p>
        <div class="mt-6">
            <DatePicker
                v-model="date"
                :disabled-dates="disabledDates"
                :min-date="new Date()"
                @dayclick="updateDate(date)"
                transparent
                borderless
                expanded
            />
        </div>
    </div>
</template>
