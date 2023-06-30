<script setup>
import {ref} from 'vue'
import Calendar from '@/Components/Calendar.vue'
import TimeSlots from '@/Components/TimeSlots.vue'

const selectedDate = ref(null)

const updateDate = (date) => {
    selectedDate.value = date
}
</script>

<template>
    <Calendar @update-date="updateDate" />
    <TimeSlots :selected-date="selectedDate" />
</template>
