<script setup>
import {useForm} from '@inertiajs/vue3'

const emit = defineEmits(['close'])

const form = useForm({
    amount: null,
})

const closeModal = () => {
    form.reset()
    emit('close')
}

</script>

<template>
    <div class="absolute top-0 left-0 flex justify-center items-center w-full h-full bg-black bg-opacity-10">
        <div class="flex flex-col items-center justify-center bg-white">
            <p @click="closeModal()" class="p-10 cursor-pointer">Close</p>
            <h1 class="p-10">This is a Modal</h1>
        </div>
    </div>
</template>
