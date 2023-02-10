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

<script setup lang="ts">
import { inject, ref } from 'vue';
import { useRouter } from 'vue-router';
import { loading } from '../../../plugins/loading';
import { useAuthStore } from '../../../stores/auth';
import { axiosInstance } from '../../../plugins/axios';

const router = useRouter();
const authStore = useAuthStore();
const swal = inject<any>('$swal');

const email = ref('');
const password = ref('');

const login = async () => {
    const loader = loading.show();

    try {
        await axiosInstance.post('/api/login-check', {
            email: email.value,
            password: password.value
        })
            .then(response => {
                loader.hide();
                authStore.authenticate(response.data.token, response.data.roles);
            })

    } catch (error: any) {
        console.log(error);

        loader.hide();
        swal({
            title: error.response.data.message,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}
</script>

<style>

</style>