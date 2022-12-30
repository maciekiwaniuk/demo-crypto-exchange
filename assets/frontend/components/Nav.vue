<template>
    <nav>
        <router-link :to="{ name: 'home' }">Home</router-link> <br>

        <router-link :to="{ name: 'login' }" v-if="!authStore.isAuthenticated">Login</router-link> <br>

        <router-link :to="{ name: 'registration' }" v-if="!authStore.isAuthenticated">Registration</router-link>

        <br> <br> <hr>
    </nav>


</template>

<script setup>
import { useAuthStore } from '../stores/auth';

const authStore = useAuthStore();
</script>

<style>

</style>