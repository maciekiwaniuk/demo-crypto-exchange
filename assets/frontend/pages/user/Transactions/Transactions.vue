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
        <tr v-for="(crypto, index) in userCryptos" :key="index">
            <td class="border border-slate-600">{{ crypto[0] }}</td>
            <td class="border border-slate-600">{{ crypto[1].number }}</td>
            <td class="border border-slate-600">{{ crypto[1].value }}</td>
        </tr>
    </table>

    <p>Value in total: {{ totalValueOfOwnedCryptos }}</p>

    <br /> <br />

    <h2>Current crypto prices</h2>
    <div v-for="crypto in cryptos">
        {{ crypto.symbol.replace('USDT', '') }} has price {{ round(crypto.price, 2) }}$ <br />
    </div>

    <br /> <br />

    List of your transactions:
    <div>
        <table class="m-auto">
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>crypto bought</th>
                <th>number bought</th>
                <th>crypto sold</th>
                <th>number sold</th>
                <th>value</th>
            </tr>
            <tr v-for="transaction in transactions">
                <td class="border border-slate-600">{{ transaction.id }}</td>
                <td class="border border-slate-600">{{ transaction.type }}</td>
                <td class="border border-slate-600">{{ transaction.cryptoBought?.symbol }}</td>
                <td class="border border-slate-600">{{ transaction.numberOfCryptoBought }}</td>
                <td class="border border-slate-600">{{ transaction.cryptoSold?.symbol }}</td>
                <td class="border border-slate-600">{{ transaction.numberOfCryptoSold }}</td>
                <td class="border border-slate-600">{{ transaction.value }}</td>
            </tr>
        </table>
    </div>

    <br /> <br />

    <h2 class="text-3xl text-orange-400">Make transaction</h2>
    Balance: {{ userStore.balance }}$ <br />
    <form @submit.prevent="newTransaction();">
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
        <input type="text" v-model="numberOfCryptoBought"> <br/>
        <label for="estimatedValueOfCryptoToBuy">Estimated value - crypto to buy</label>
        <input type="text" v-model="estimatedValueOfCryptoToBuy">

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
        <input type="text" v-model="numberOfCryptoSold"> <br/>
        <label for="estimatedValueOfCryptoToSell">Estimated value - crypto to sell</label>
        <input type="text" v-model="estimatedValueOfCryptoToSell">

        <br />
        <br />

        <button
            type="submit"
            class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full"
        >Make</button>

    </form>
</template>

<script setup lang="ts">
import { computed, reactive, ref} from 'vue';
import { axiosInstance } from '../../../plugins/axios';
import { TransactionOptionFormType } from '../../../interfaces/TransactionOptionFormType';
import { useCryptoDataFetcher } from '../../../composables/useCryptoDataFetcher';
import { cryptoDataRefreshRate } from '../../../constants/app';
import { round } from '../../../utils/round';
import { useUserStore } from '../../../stores/user';

const userStore = useUserStore();

const transactions = reactive<any[]>([]),
      cryptos = reactive<any[]>([]),
      userCryptos = reactive<any[]>([]);

let type = ref<null | TransactionOptionFormType>(null),
    cryptoSoldSymbol = ref<null | string>(),
    cryptoBoughtSymbol = ref<null | string>(),
    numberOfCryptoSold = ref<null | number>(),
    numberOfCryptoBought = ref<null | number>(),
    value = ref<null | number>();

let estimatedValueOfCryptoToBuy = computed(() => {
    if (! cryptos.length || type.value === null) return;

    let value = 0;
    cryptos.forEach(crypto => {
        if (crypto.symbol === cryptoBoughtSymbol.value) {
            // @ts-ignore
            value = numberOfCryptoBought.value * crypto.price;
        }
    });

    return value;
});

let estimatedValueOfCryptoToSell = computed(() => {
    if (! cryptos.length || type.value === null) return;

    let value = 0;
    cryptos.forEach(crypto => {
        if (crypto.symbol === cryptoSoldSymbol.value) {
            // @ts-ignore
            value = numberOfCryptoSold.value * crypto.price;
        }
    });

    return value;
});

let totalValueOfOwnedCryptos = computed(() => {
    let value = 0;
    userCryptos.forEach(crypto => {
        value += crypto[1].value;
    })
    return value;
});

const { getPricesOfActiveCryptos } = useCryptoDataFetcher();

const getCryptos = async (): Promise<any> => {
    const fetchedCryptos = await getPricesOfActiveCryptos();
    Object.assign(cryptos, fetchedCryptos);
}
getCryptos();
setInterval(() => {
    getCryptos();
}, cryptoDataRefreshRate);

const getUserCryptos = async(): Promise<any> => {
    axiosInstance.get('/api/user/total-owned-crypto')
        .then(response => {
            const cryptos = JSON.parse(response.data.cryptos);
            Object.assign(userCryptos, Object.entries(cryptos));
        });
}
getUserCryptos();

const getTransactions = async (): Promise<any> => {
    await axiosInstance.get('/api/user/transactions/list')
        .then(response => {
            Object.assign(transactions, JSON.parse(response.data.transactions));
        })
}
getTransactions();

interface transactionData {
    cryptoSoldSymbol?: string | null,
    cryptoBoughtSymbol?: string | null,
    numberOfCryptoSold?: number | null,
    numberOfCryptoBought?: number | null,
    value?: number | null
}
const newTransaction = async (): Promise<any> => {
    let newTransactionUrl: string = '/api/user/transactions';
    const transactionData: transactionData = {};

    if (type.value === 'sold_for_money') {
        newTransactionUrl += '/new-sold-for-money';
        transactionData.cryptoSoldSymbol = cryptoSoldSymbol.value;
        transactionData.numberOfCryptoSold = numberOfCryptoSold.value;
        transactionData.value = estimatedValueOfCryptoToSell.value;

    } else if (type.value === 'bought_for_money') {
        newTransactionUrl += '/new-bought-for-money';
        transactionData.cryptoBoughtSymbol = cryptoBoughtSymbol.value;
        transactionData.numberOfCryptoBought = numberOfCryptoBought.value;
        transactionData.value = estimatedValueOfCryptoToBuy.value;

    } else if (type.value === 'exchange_between_cryptos') {
        newTransactionUrl += '/new-exchange-between-cryptos';
        transactionData.cryptoSoldSymbol = cryptoSoldSymbol.value;
        transactionData.numberOfCryptoSold = numberOfCryptoSold.value;
        transactionData.cryptoBoughtSymbol = cryptoBoughtSymbol.value;
        transactionData.numberOfCryptoBought = numberOfCryptoBought.value;
        transactionData.value = estimatedValueOfCryptoToBuy.value;
    }

    axiosInstance.post(newTransactionUrl, transactionData)
        .then(response => {
            if (response.data.success) {
                transactions.push(JSON.parse(response.data.transaction));
            }
        })

}
</script>