<script setup>
import { Head, Link } from '@inertiajs/vue3';
import DropdownLink from "@/Components/DropdownLink.vue";
</script>

<template>
    <Head title="Dashboard" />
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Seller Dashboard</h2>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <p>Welcome {{$page.props.auth.seller.name}}</p>
                    <div class="p-6 text-gray-900">You're logged in!</div>
                    <Link :href="route('seller.logout')" method="post" as="button">Logout</Link>
                </div>
            </div>
        </div>
</template>
