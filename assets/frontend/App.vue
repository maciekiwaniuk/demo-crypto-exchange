<template>
    <Navbar />

    <div class="container m-auto text-center mt-4">
        <router-view />
    </div>

</template>

<script setup lang="ts">
import Navbar from './components/Navbar.vue';
import { useAuthenticator } from './composables/useAuthenticator';
import { useUserStore } from "./stores/user";

const { checkAuthentication } = useAuthenticator();
checkAuthentication();

const userStore = useUserStore();
if (! userStore.isUserDataAlreadyFetched()) {
    userStore.fetchUserData();
}
</script>

<style lang="scss">
</style>
