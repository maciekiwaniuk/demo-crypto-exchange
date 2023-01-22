<template>
    <Navbar />

    <div class="container m-auto text-center mt-4">
        <router-view />
    </div>

</template>

<script setup lang="ts">
import Navbar from './components/Navbar.vue';

</script>

<style lang="scss">
</style>
