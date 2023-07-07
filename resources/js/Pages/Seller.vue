<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <h1>Create a Seller account to begin selling your services!</h1>
    <p>Create a seller account <Link :href="route('seller.register')">here</Link></p>
</template>
