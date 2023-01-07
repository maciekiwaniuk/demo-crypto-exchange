<template>
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
