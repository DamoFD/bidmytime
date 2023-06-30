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
        <h2 class="text-xl font-nunito font-black">{{ formattedDate }}</h2>
    </div>
</template>
