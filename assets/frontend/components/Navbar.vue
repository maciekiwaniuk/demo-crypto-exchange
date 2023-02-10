<template>
    <nav class="bg-gray-800 px-4 py-3 flex items-center justify-between">

        <div class="flex items-center">
            <router-link :to="{ name: 'home' }" class="text-lg text-yellow-400 font-semibold mr-6">
                Crypto exchange
            </router-link>

<!--            <div class="relative">-->
<!--                <button class="dropdown-button focus:outline-none text-white"> Opcja 1-->
<!--                    <div class="dropdown-content absolute right-0 mt-2 py-2 bg-gray-800 rounded-lg shadow-lg z-10">-->
<!--                        <a class="block px-4 py-2 text-white hover:bg-gray-700"> Opcja 2 </a>-->
<!--                        <a class="block px-4 py-2 text-white hover:bg-gray-700"> Opcja 3 </a>-->
<!--                    </div>-->
<!--                </button>-->
<!--            </div>-->
        </div>

        <div
            v-if="authStore.isAuthenticated"
            class="flex text-red-800"
        >
            <router-link
                :to="{ name: 'user.transactions' }"
                class="px-4 py-2 font-semibold text-white hover:bg-gray-700 mr-4"
            >Transactions</router-link> <br>

            <router-link
                :to="{ name: 'user.account' }"
                class="px-4 py-2 font-semibold text-white hover:bg-gray-700 mr-4"
            >Account</router-link> <br>

            <button
                @click="logout();"
                class="px-4 py-2 font-semibold text-white hover:bg-gray-700 mr-4"
            >Logout</button>
        </div>

        <div
            v-if="!authStore.isAuthenticated"
            class="flex text-red-800"
        >
            <router-link
                :to="{ name: 'login' }"
                class="px-4 py-2 font-semibold text-white hover:bg-gray-700 mr-4"
            >Login</router-link> <br>

            <router-link
                :to="{ name: 'registration' }"
                class="px-4 py-2 font-semibold text-white hover:bg-gray-700 mr-4"
            >Registration</router-link> <br>
        </div>

        <div
            v-if="authStore.isAdmin()"
            class="flex text-red-800"
        >
            <router-link
                :to="{ name: 'admin.cryptocurrencies' }"
                class="px-4 py-2 font-semibold hover:bg-gray-700 mr-4"
            >Cryptocurrencies</router-link>
        </div>

        <button
            class="nav-hamburger-toggler"
            aria-label="Hamburger"
        >
            <span class="bar bar-short"></span>
            <span class="bar"></span>
            <span class="bar bar-medium"></span>
        </button>
    </nav>
</template>

<script setup>
import { useAuthStore } from '../stores/auth';
import { loading } from '../plugins/loading';

const authStore = useAuthStore();

const logout = () => {
    const loader = loading.show();

    setTimeout(() => {
        loader.hide();
        authStore.logout();
    }, 500);
}
</script>

<style lang="scss" scoped>
.nav-hamburger-toggler {
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
    width: 2.6rem;
    height: 1.8rem;
    border: none;
    background-color: transparent;
    cursor: pointer;

    transition: background-color ease 0.2s;

    .bar {
        height: 0.25rem;
        width: 100%;
        border-radius: 10px;
        transition: background-color ease 0.2s;
        background-color: white;
    }
    .bar-short {
        width: 50%;
    }
    .bar-medium {
        width: 80%;
    }
}
</style>