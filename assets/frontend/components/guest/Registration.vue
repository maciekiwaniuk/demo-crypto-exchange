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
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';
import { axiosInstance } from '../../plugins/axios';

const router = useRouter();
const authStore = useAuthStore();

const email = ref(''),
      username = ref(''),
      password = ref(''),
      password_confirm = ref('');

const handleRegistration = async () => {
    console.log(email.value);
    console.log(username.value);
    console.log(password.value);
    await axiosInstance.post('/api/register', {
        username: username.value,
        email: email.value,
        password: password.value
    })
        .then(response => {
            if (!response.data.success) {
                Swal({
                    title: 'Whoops...',
                    text: Object.values(response.data.errors)[0],
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
                return;
            }

            authStore.authenticate(response.data.token, response.data.roles);
            router.push({ name: 'home' });
            console.log('response');
            console.log(response);
        })
        .catch(error => {
            console.log('error');
            console.log(error);
        })
}
</script>