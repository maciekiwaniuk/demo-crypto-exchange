<template>
    <h1 class="text-5xl text-yellow-400">Home page</h1>

    <p class="test1234">Welcome on home page!</p>

    <br>

    Cryptocurrencies:

    <div v-for="crypto in cryptos">
        {{ crypto.symbol.replace('USDT', '') }} has price {{ crypto.price }} <br />
    </div>
</template>

<script setup lang="ts">
import { axiosInstance } from '../../plugins/axios';
import { reactive } from 'vue';

const cryptos = reactive<any[]>([]);

const getCryptos = async () => {
    axiosInstance.get('api/get_prices_of_active_cryptos')
        .then(response => {
            console.log(response);
            Object.assign(cryptos, response.data.cryptos);
        })
}
getCryptos();

</script>

<style scoped>

</style>