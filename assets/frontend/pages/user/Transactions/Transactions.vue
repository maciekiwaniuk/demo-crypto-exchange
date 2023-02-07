<template>
    <h1 class="text-4xl text-yellow-400">Transactions page</h1>

    <br /> <br />

    <h2>Your cryptocurrencies</h2>
    <table class="table-auto m-auto">
        <tr>
            <th>Crypto</th>
            <th>Number</th>
            <th>Value</th>
        </tr>
        <tr v-for="userCrypto in userCryptos">

        </tr>
    </table>

    <br /> <br />

    <h2>Current crypto prices</h2>
    <div v-for="crypto in cryptos">
        {{ crypto.symbol.replace('USDT', '') }} has price {{ round(crypto.price, 2) }}$ <br />
    </div>

    <br /> <br />

    List of your transactions:
    <div v-for="transaction in transactions">
        tako <br/>
    </div>

    <br /> <br />

    <h2 class="text-3xl text-orange-400">Make transaction</h2>
    Balance: {{ userStore.balance }}$ <br />
    <form @submit.prevent="runTransaction();">
        <label for="type">Type</label>
        <select v-model="type" id="type">
            <option value="sold_for_money">Sell crypto for money</option>
            <option value="bought_for_money">Buy crypto for money</option>
            <option value="exchange_between_cryptos">Exchange between cryptos</option>
        </select>

        <br />
        <br />

        <label for="cryptoBoughtSymbol">Crypto TO (buy or exchange)</label>
        <select v-model="cryptoBoughtSymbol">
            <option value=""></option>
            <option v-for="crypto in cryptos" :value="crypto.symbol">
                {{ crypto.symbol.replace('USDT', '') }}
            </option>
        </select>

        <br />

        <label for="numberOfCryptoBought">Number of crypto to buy or exchange</label>
        <input type="text" v-model="numberOfCryptoBought">

        <br />
        <br />

        <label for="cryptoSoldSymbol">Crypto FROM (sell or exchange)</label>
        <select v-model="cryptoSoldSymbol">
            <option value=""></option>
            <option v-for="crypto in cryptos" :value="crypto.symbol">
                {{ crypto.symbol.replace('USDT', '') }}
            </option>
        </select>

        <br />

        <label for="numberOfCryptoSold">Number of crypto to sell or exchange</label>
        <input type="text" v-model="numberOfCryptoSold">

        <br />
        <br />

        <button
            type="submit"
            class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full"
        >Make</button>

    </form>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import { axiosInstance } from '../../../plugins/axios';
import { TransactionOptionFormType } from '../../../interfaces/TransactionOptionFormType';
import { useCryptoDataFetcher } from '../../../composables/useCryptoDataFetcher';
import { cryptoDataRefreshRate } from '../../../constants/app';
import { round } from '../../../utils/round';
import { useUserStore } from '../../../stores/user';

const userStore = useUserStore();
if (! userStore.isUserDataAlreadyFetched()) {
    userStore.fetchUserData();
}

const transactions = reactive<any[]>([]),
      cryptos = reactive<any[]>([]),
      userCryptos = reactive<[]>([]);

let type = ref<null | TransactionOptionFormType>(null),
    cryptoSoldSymbol = ref<null | string>(),
    cryptoBoughtSymbol = ref<null | string>(),
    numberOfCryptoSold = ref<null | number>(),
    numberOfCryptoBought = ref<null | number>(),
    value = ref<null | number>();

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

const runTransaction = async (): Promise<any> => {
    await axiosInstance.post('/api/user/transactions/new', {

    })
        .then(response => {
            console.log(response);
        })
}

</script>