<script setup>
import {ref, defineEmits, onMounted, computed} from 'vue'
import {DatePicker} from 'v-calendar'
import 'v-calendar/style.css'
import useDisabledDates from "@/Composables/useDisabledDates.js";
import useFindWeekdayIdByDate from "@/Composables/useFindWeekdayIdByDate.js";
import useAvailableDaysOfWeek from "@/Composables/useAvailableDaysOfWeek.js";

const date = ref(new Date())
const props = defineProps({
    seller: Object
})

const weekdays = ref(props.seller.available_weekdays)

// Get an array of the available weekdays
const availableDaysOfWeek = useAvailableDaysOfWeek(weekdays)

// List of disabled dates
const disabledDates = useDisabledDates(availableDaysOfWeek, props.seller.available_exceptions)

const findWeekdayIdByDate = useFindWeekdayIdByDate(weekdays)

//Emit current date on mount
onMounted(() => {
    updateDate(date.value)
})

const emit = defineEmits(['update-date'])

//Emit date to parent
const updateDate = (date) => {
    const weekdayId = findWeekdayIdByDate(date)
    emit('update-date', date, weekdayId)
}
</script>

<template>
    <!-- Main Wrapper -->
    <div class="flex flex-col items-center w-11/12 md:w-1/2">
            <DatePicker
                v-model="date"
                :disabled-dates="disabledDates"
                :min-date="new Date()"
                color="green"
                @dayclick="updateDate(date)"
                transparent
                borderless
                expanded
            />
    </div>
</template>
