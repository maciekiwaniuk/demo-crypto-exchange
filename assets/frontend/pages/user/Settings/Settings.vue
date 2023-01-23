<template>
    <h1>Settings</h1>
    <form @submit.prevent="changePassword();">
        <label for="old_password">Old password</label>
        <input type="password" id="old_password" v-model="old_password"> <br>

        <label for="new_password">New password</label>
        <input type="password" id="new_password" v-model="new_password"> <br>

        <label class="new_password_confirm">Confirm new password</label>
        <input type="password" id="new_password_confirm" v-model="new_password_confirm"> <br>

        <button type="submit">Change password</button>
    </form>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { axiosInstance } from '../../../plugins/axios';

const old_password = ref<string>('');
const new_password = ref<string>('');
const new_password_confirm = ref<string>('');

const changePassword = async () => {
    try {
        const response = await axiosInstance.post('/api/user/change_password', {
            old_password: old_password.value,
            new_password: new_password.value,
            new_password_confirm: new_password_confirm.value
        });
        console.log('response');
        console.log(response);
    } catch (error) {
        console.log('error');
        console.log(error);
    }
}
</script>

<style scoped>

</style>