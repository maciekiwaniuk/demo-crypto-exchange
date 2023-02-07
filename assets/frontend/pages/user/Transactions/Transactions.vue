<template>
    <h1>Transactions</h1>

    <h2>Balance</h2>
    100 000$

    <br /> <br />

    <h2>Current crypto prices</h2>
    <div v-for="crypto in cryptos">
        {{ crypto.symbol.replace('USDT', '') }} has price {{ crypto.price }} <br />
    </div>

    <br /> <br />

    List of your transactions:
    <div v-for="transaction in transactions">
        tako <br/>
    </div>

    <br /> <br />

    <h2>Make transaction</h2>

    <br />

    <form @submit.prevent>
        <label for="type">Type</label>
        <select v-model="type" id="type">
            <option value="sold_for_money">Sell crypto for money</option>
            <option value="bought_for_money">Buy crypto for money</option>
            <option value="exchange_between_cryptos">Exchange between cryptos</option>
        </select>

        <br />


    </form>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import { axiosInstance } from '../../../plugins/axios';
import { TransactionOptionFormType } from '../../../interfaces/TransactionOptionFormType';
import { useCryptoDataFetcher } from '../../../composables/useCryptoDataFetcher';
import { cryptoDataRefreshRate } from '../../../constants/app';

const transactions = reactive<any[]>([]);
const cryptos = reactive<any[]>([]);

let type = ref<null | TransactionOptionFormType>(null);

const { getPricesOfActiveCryptos } = useCryptoDataFetcher();

const getCryptos = async (): Promise<any> => {
    const fetchedCryptos = await getPricesOfActiveCryptos();
    Object.assign(cryptos, fetchedCryptos);
}
getCryptos();
setInterval(() => {
    getCryptos();
}, cryptoDataRefreshRate);

const getTransactions = async (): Promise<any> => {
    await axiosInstance.get('/api/user/transactions/list')
        .then(response => {
            console.log(response);
        })
}
getTransactions();

</script>