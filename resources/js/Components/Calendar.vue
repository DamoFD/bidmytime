<script setup>
import {ref} from 'vue'
import {DatePicker} from 'v-calendar'
import 'v-calendar/style.css'

const date = ref(new Date())
const disabledDates = ref([
    {
        repeat: {
            weekdays: [1, 7],
        }
    }
])
</script>

<template>
    <DatePicker v-model="date" :disabled-dates="disabledDates" />
    <p>{{date}}</p>
</template>
