<template>
    <div>
        Token: {{ authStore.token }} <br>
        User logged in: {{ authStore.isAuthenticated ? 'yes' : 'no' }}
        <button v-if="authStore.isAuthenticated" @click="authStore.logout();">
            Logout
        </button>
    </div>
    <Nav />
    <router-view />
</template>

<script setup>
import Nav from './components/Nav.vue';
import { useAuthStore } from './stores/auth';

const authStore = useAuthStore();
</script>

<style lang="scss">
</style>
