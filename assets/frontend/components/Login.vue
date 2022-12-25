<template>
    <h1>Login page</h1>

    <form @submit.prevent="login();">
        <label for="email">Email</label>
        <input type="text" id="email" v-model="email">

        <br>
        <label for="password">Password</label>
        <input type="password" v-model="password">

        <br>
        <button type="submit">Login</button>
    </form>

</template>

<script setup>
import axios from 'axios';
import { ref } from "vue";
import { useAuthStore } from "../stores/auth";

const email = ref('');
const password = ref('');

const authStore = useAuthStore();

const login = async () => {

    try {
        const response = await axios.post('/api/login_check', {
            email: email.value,
            password: password.value
        });

        console.log(response);
    } catch (error) {
        console.log(error.response.data.message);
    }
}


</script>

<style scoped>

</style>