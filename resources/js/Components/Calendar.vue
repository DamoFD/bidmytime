<script setup>
import {ref, defineEmits, onMounted} from 'vue'
import {DatePicker} from 'v-calendar'
import 'v-calendar/style.css'

const date = ref(new Date())

//List of disabled dates
const disabledDates = ref([
    {
        repeat: {
            weekdays: [1, 7],
        }
    }
])

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
        <h1 class="text-2xl font-nunito font-black text-gray-800">Your Business Here</h1>
        <p class="font-inter">Select a date and bid on your desired time slot!</p>
        <div class="mt-6">
            <DatePicker
                v-model="date"
                :disabled-dates="disabledDates"
                :min-date="new Date()"
                @dayclick="updateDate(date)"
                transparent
                borderless
            />
        </div>
    </div>
</template>

<style>
/* Change color of Weekdays */
.vc-container .vc-weekday-2,
.vc-container .vc-weekday-3,
.vc-container .vc-weekday-4,
.vc-container .vc-weekday-5,
.vc-container .vc-weekday-6 {
    color: blue
}
</style>
