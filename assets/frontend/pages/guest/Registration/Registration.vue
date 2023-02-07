<template>
    <h1>Registration page</h1>

    <form @submit.prevent="handleRegistration();">
        <label for="username">Username</label>
        <input type="text" id="username" v-model="username"> <br>

        <label for="email">Email</label>
        <input type="text" id="email" v-model="email"> <br>

        <label for="password">Password</label>
        <input type="password" id="password" v-model="password"> <br>

        <label for="passwordConfirm">Confirm password</label>
        <input type="password" id="passwordConfirm" v-model="passwordConfirm"> <br>

        <button type="submit">Register</button>
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

const email = ref<string>(''),
      username = ref<string>(''),
      password = ref<string>(''),
      passwordConfirm = ref<string>('');

const handleRegistration = async () => {
    const loader = loading.show();

    if (password.value !== passwordConfirm.value) {
        swal({
            title: 'Whoops...',
            text: 'Confirmation of password was different than in password field.',
            icon: 'error',
            confirmButtonText: 'OK'
        })
        return;
    }

    await axiosInstance.post('/api/register', {
        username: username.value,
        email: email.value,
        password: password.value
    })
        .then(response => {
            loader.hide();

            if (!response.data.success) {
                swal({
                    title: 'Whoops...',
                    text: Object.values(response.data.errors)[0],
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
                return;
            }

            authStore.authenticate(response.data.token, response.data.roles);
            router.push({ name: 'home' });
        })
        .catch(error => {
            loader.hide();
            console.log(error);
        })
}
</script>