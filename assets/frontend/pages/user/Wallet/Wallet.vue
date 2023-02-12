<template>
    <h1 class="text-4xl text-yellow-400">Wallet</h1>

    <br /> <br />

    <table class="table-auto m-auto">
        <tr>
            <th>Crypto</th>
            <th>Amount</th>
            <th>Value</th>
        </tr>
        <tr v-for="crypto in summedWallet" :key="crypto.symbol">
            <td class="border border-slate-600">{{ crypto.symbol }}</td>
            <td class="border border-slate-600">{{ crypto.amount }}</td>
            <td class="border border-slate-600">{{ crypto.value }} USD</td>
        </tr>
    </table>

</template>

<script setup lang="ts">
import { computed, reactive } from 'vue';
import { axiosInstance } from '../../../plugins/axios';
import { useCryptoDataFetcher } from '../../../composables/useCryptoDataFetcher';
import { cryptoDataRefreshRate } from '../../../constants/app';

const cryptoPrices = reactive<any[]>([]);

const { getPricesOfActiveCryptos } = useCryptoDataFetcher();

const getCryptoPrices = async (): Promise<any> => {
    const fetchedCryptoPrices = await getPricesOfActiveCryptos();
    console.log(fetchedCryptoPrices);
    Object.assign(cryptoPrices, fetchedCryptoPrices);
}
getCryptoPrices();
setInterval(() => {
    getCryptoPrices();
}, cryptoDataRefreshRate);

const userCryptos = reactive<any[]>([]);

const getUserCryptos = async(): Promise<any> => {
    axiosInstance.get('/api/user/total-owned-crypto')
        .then(response => {
            const cryptos = JSON.parse(response.data.cryptos);
            console.log(cryptos);
            console.log(Object.entries(cryptos));
            Object.assign(userCryptos, Object.entries(cryptos));
        });
}
getUserCryptos();

const summedWallet = computed(() => {
   if (!userCryptos.length || !cryptoPrices.length) {
       return [];
   }

   const wallet: any[] = [];
   userCryptos.forEach((userCrypto) => {
       const symbol = userCrypto[0].replace('USDT', ''),
             amount = userCrypto[1],
             crypto = cryptoPrices.find(
                 crypto => crypto.symbol.replace('USDT', '') === symbol
             );

       wallet.push({
           symbol: symbol,
           amount: amount,
           value: amount * crypto.price
       });
   });

   return wallet;
});

</script>