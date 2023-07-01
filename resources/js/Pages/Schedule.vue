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
    <!-- Main Wrapper -->
    <div class="min-h-screen w-full flex items-center justify-center bg-gray-300">
        <div class="flex w-full m-10 bg-white rounded-xl">
            <Calendar @update-date="updateDate" />
            <TimeSlots :selected-date="selectedDate" />
        </div>
    </div>
</template>
