<template>
    <h1>Registration page</h1>

    <form @submit.prevent="handleRegistration();">
        <label for="username">Username</label>
        <input type="text" id="username" v-model="username"> <br>

        <label for="email">Email</label>
        <input type="text" id="email" v-model="email"> <br>

        <label for="password">Password</label>
        <input type="password" id="password" v-model="password"> <br>

        <label for="password_confirm">Confirm password</label>
        <input type="password" id="password_confirm" v-model="password_confirm"> <br>

        <button type="submit">Register</button>
    </form>
</template>

<script setup>
import { ax } from '../../axios';
import { ref } from "vue";

const email = ref(''),
      username = ref(''),
      password = ref(''),
      password_confirm = ref('');

const handleRegistration = async () => {
    await ax.post('/api/register', {
        username: username.value,
        email: email.value,
        password: password.value
    }, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            console.log(response);
        })
        .catch(error => {
            console.log(error);
        })
}
</script>