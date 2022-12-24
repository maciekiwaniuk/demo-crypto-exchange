<template>
    <h1>Registration page</h1>

    <form @submit.prevent="register();">
        <label for="email">Email</label>
        <input type="text" id="email" v-model="email"> <br>

        <label for="username">Username</label>
        <input type="text" id="username" v-model="username"> <br>

        <label for="password">password</label>
        <input type="password" id="password" v-model="password"> <br>

        <button type="submit">Register</button>
    </form>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";

const email = ref('');
const username = ref('');
const password = ref('');

const register = async () => {
    await axios.post('/api/register', {

    }, {
        headers: {

        }
    })
}
</script>