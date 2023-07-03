<script setup>
import {Link} from '@inertiajs/vue3'

const props = defineProps({
    sellers: Object,
})
</script>

<template>
    <div class="flex flex-col w-full items-center">
        <h1>Sellers</h1>
        <div v-for="seller in sellers">
            <Link :href="route('sellers.show', seller.id)">
                <h3>{{seller.name}}</h3>
            </Link>
        </div>
    </div>
</template>
