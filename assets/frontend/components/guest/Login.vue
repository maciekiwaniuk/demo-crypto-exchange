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

        <br>

    </form>

    <br>
    <hr>
    <br>
    <button @click="test();">Testing</button>


</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '../../stores/auth';
import { useRouter } from 'vue-router';
import { useAuth } from "@websanova/vue-auth";
import axios from '../../axios';

const email = ref('');
const password = ref('');


// const authStore = useAuthStore();
const router = useRouter();

const auth = useAuth();

const test = async () => {
    try {
        console.log('REQUEST PRZEZ auth.login({})')
        const response = await auth.login({
            data: {
                email: email.value,
                password: password.value
            },
            headers: {
                'Content-Type': 'application/json'
            }
        })
        console.log('response');
        console.log(response)
    } catch (error) {
        console.log('error');
        console.log(error);
    }
}

const login = async () => {
    try {
        console.log('REQUEST PROSTO PRZEZ axios.post');
        const response = await axios.post('/api/login_check', {
            email: email.value,
            password: password.value
        });

        console.log('response');
        console.log(response);
        // authStore.setAuthenticationToken(response.data.token);
        // await router.push({ name:'home' });

    } catch (error) {
        console.log(error.response.data.message);
    }
}


</script>

<style scoped>

</style>