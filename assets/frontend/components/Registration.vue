<template>
    <h1>Registration page</h1>
    
    <form @submit.prevent="register();">
        <label for="email">Email</label>
        <input type="text" id="email" v-model="email">
    </form>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";

const email = ref('');

const register = async () => {
    await axios.post('/api/register', {

    }, {
        headers: {

        }
    })
}
</script>