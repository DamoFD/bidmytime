<script setup>
const props = defineProps({
    bids: Array
})

console.log(props.bids)
</script>

<template>
    <div>
        <h1>Bids</h1>
        <div v-for="bid in bids" :key="bid.id">
            <p>{{ bid.user_id }}: ${{ bid.amount }}</p>
            <p>{{bid.seller.name}}</p>
        </div>
    </div>
</template>
