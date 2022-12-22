<template>
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

const props = defineProps(['email', 'password']);

const login = async () => {

    const response = await axios.post('/api/check-login', {
        email: props.email,
        password: props.password
    })
        .then(response => {
            console.log(response);
        });
}
</script>

<style scoped>

</style>