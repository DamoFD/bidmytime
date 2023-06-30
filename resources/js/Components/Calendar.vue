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
    <h1>Your Business Here</h1>
    <DatePicker v-model="date" :disabled-dates="disabledDates" :min-date="new Date()" @dayclick="updateDate(date)" />
    <p>{{date}}</p>
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
