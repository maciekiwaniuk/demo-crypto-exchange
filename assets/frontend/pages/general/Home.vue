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
import { reactive } from 'vue';
import { useCryptoDataFetcher } from '../../composables/useCryptoDataFetcher';

const cryptos = reactive<any[]>([]);

const { getPricesOfActiveCryptos } = useCryptoDataFetcher();

const getCryptos = async () => {
    const fetchedCryptos = await getPricesOfActiveCryptos();
    Object.assign(cryptos, fetchedCryptos);
}
getCryptos();

</script>

<style scoped>

</style>