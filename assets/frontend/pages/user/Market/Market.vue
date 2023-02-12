<template>
    <h1 class="text-4xl text-yellow-400">Market</h1>

    <br /> <br />

    <h2>Current crypto prices</h2>
        <table class="m-auto">
            <tr>
                <th class="border-2 border-black p-2">Cryptocurrency</th>
                <th class="border-2 border-black p-2">Price</th>
            </tr>
            <tr v-for="crypto in cryptos">
                <td class="border-2 border-black p-2">{{ crypto.symbol.replace('USDT', '') }}</td>
                <td class="border-2 border-black p-2">{{ round(crypto.price, 2) }} USD</td>
            </tr>
        </table>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { useCryptoDataFetcher } from '../../../composables/useCryptoDataFetcher';
import { cryptoDataRefreshRate } from '../../../constants/app';
import { round } from '../../../utils/round';

const cryptos = reactive<any[]>([]);

const { getPricesOfActiveCryptos } = useCryptoDataFetcher();

const getCryptos = async (): Promise<any> => {
    const fetchedCryptos = await getPricesOfActiveCryptos();
    Object.assign(cryptos, fetchedCryptos);
}
getCryptos();
setInterval(() => {
    getCryptos();
}, cryptoDataRefreshRate);
</script>