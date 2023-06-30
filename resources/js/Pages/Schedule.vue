<script setup>
import {ref} from 'vue'
import Calendar from '@/Components/Calendar.vue'

const selectedDate = ref(null)

const updateDate = (date) => {
    selectedDate.value = date
}
</script>

<template>
    <Calendar @update-date="updateDate" />
    <p>{{ selectedDate }}</p>
</template>
