<script setup>
import {ref, computed} from 'vue'
import moment from 'moment'

const props = defineProps(['selectedDate'])

//Format Date
const formattedDate = computed(() => {
    return moment(props.selectedDate).format('MMMM Do, YYYY');
})
</script>

<template>
    <!-- Main Wrapper -->
    <div class="flex flex-col justify-center items-center w-1/2">
        <h2 class="text-xl font-nunito font-black text-gray-700">{{ formattedDate }}</h2>
        <p class="text-md font-inter">What time works best?</p>

        <!-- Time Slots -->
        <div class="flex flex-col items-center w-full p-4">
            <div class="border border-gray-300 w-full h-10 flex items-center justify-center rounded-xl">
                <h3 class="font-inter">9:00 am</h3>
            </div>
        </div>
    </div>
</template>
