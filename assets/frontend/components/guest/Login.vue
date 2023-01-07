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
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';
import { axiosInstance } from '../../plugins/axios';

const router = useRouter();
const authStore = useAuthStore();

const email = ref(null);
const password = ref(null);

const login = async () => {
    try {
        const response = await axiosInstance.post('/api/login_check', {
            email: email.value,
            password: password.value
        });
        console.log(response);
        await authStore.authenticate(response.data.token, response.data.roles);

    } catch (error) {
        console.log(error);
        Swal({
            title: error.response.data.message,
            icon: 'error',
            confirmButtonText: 'OK'
        });
        console.log(error);
        console.log(error.response.data.message);
    }
}
</script>

<style scoped>

</style>