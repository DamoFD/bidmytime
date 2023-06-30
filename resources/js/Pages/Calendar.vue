<script setup>
import {ref} from 'vue'
import {DatePicker} from 'v-calendar'
import 'v-calendar/style.css'

const date = ref(new Date())
</script>

<template>
    <DatePicker v-model="date" />
    <p>{{date}}</p>
</template>
