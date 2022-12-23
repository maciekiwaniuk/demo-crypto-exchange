<template>
    <form @submit.prevent="login();">
        <label for="email">Emdsadsaail</label>
        <input type="text" id="email" v-model="email">

        <br>
        <label for="password">Password</label>
        <input type="password" v-model="password">

        <br>
        <button type="submit">Login</button>
    </form>

    <br>

    <button @click="checkAuthentication();">Check authentication</button>
</template>

<script setup>
import axios from 'axios';
import { ref } from "vue";
import { useAuthStore } from "../stores/auth";

const email = ref('');
const password = ref('');

const authStore = useAuthStore();

const login = async () => {
    console.log('request na /api/login');

    // await fetch('/api/login_check', {
    //     headers: {
    //         'Content-Type': 'application/json'
    //     },
    //     method: 'POST',
    //     body: JSON.stringify({email: email.value, password: password.value}
    // )})
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.error) {
    //             console.log(data.error);
    //             return;
    //         }
    //         console.log(data);
    //         // authStore.setAuthenticationToken(data.token);
    //     });



    await axios.post('/api/login_check', {
        email: email.value,
        password: password.value
    }, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            console.log('response');
            console.log(response);
        })
        .catch(error => {
            console.log('error');
            console.log(error.response.data.message);
        })
}


</script>

<style scoped>

</style>