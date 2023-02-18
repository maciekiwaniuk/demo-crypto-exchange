<template>
    <h1 class="text-4xl text-yellow-400">Market</h1>

    <br /> <br />

    <h2>Current crypto prices</h2>
    <table class="m-auto">
        <tr>
            <th class="border-2 border-black p-2">Cryptocurrency</th>
            <th class="border-2 border-black p-2">Price</th>
        </tr>
        <tr
            v-for="crypto in cryptos"
            @click="showNewOrderModal(crypto.symbol);"
            class="bg-sky-500 hover:bg-sky-700 cursor-pointer"
        >
            <td class="border-2 border-black p-2">{{ crypto.symbol.replace('USDT', '') }}</td>
            <td class="border-2 border-black p-2">{{ round(crypto.price, 2) }} USD</td>
        </tr>
    </table>

    <br />
    <br />

    <h2>Orders</h2>
    <table class="m-auto">
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>crypto to buy</th>
            <th>number to buy</th>
            <th>crypto to sell</th>
            <th>number to sell</th>
            <th>value</th>
            <th>status</th>
        </tr>
        <tr v-for="order in orders">
            <td class="border border-slate-600">{{ order.id }}</td>
            <td class="border border-slate-600">{{ order.type }}</td>
            <td class="border border-slate-600">{{ order.cryptoToBuy?.symbol }}</td>
            <td class="border border-slate-600">{{ order.amountOfCryptoToBuy }}</td>
            <td class="border border-slate-600">{{ order.cryptoToSell?.symbol }}</td>
            <td class="border border-slate-600">{{ order.amountOfCryptoToSell }}</td>
            <td class="border border-slate-600">{{ order.value }}</td>
            <td class="border border-slate-600">{{ order.status }}</td>
        </tr>
    </table>
    
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import { useCryptoDataFetcher } from '../../../composables/useCryptoDataFetcher';
import { cryptoDataRefreshRate } from '../../../constants/app';
import { round } from '../../../utils/round';
import { useModal } from 'vue-final-modal';
import { axiosInstance } from '../../../plugins/axios';
import ModalNewOrder from './ModalNewOrder.vue';

const cryptos = reactive<any[]>([]),
      symbol = ref<string>('');

const { getPricesOfActiveCryptos } = useCryptoDataFetcher();

const getCryptos = async (): Promise<void> => {
    const fetchedCryptos = await getPricesOfActiveCryptos();
    Object.assign(cryptos, fetchedCryptos);
}
getCryptos();
setInterval(() => {
    getCryptos();
}, cryptoDataRefreshRate);

const orders = reactive<any[]>([]);
const getOrders = async (): Promise<void> => {
    axiosInstance.get('/api/user/market/get-orders')
        .then(response => {
            Object.assign(orders, JSON.parse(response.data.orders))
        });
}
getOrders();

const { open, close, options } = useModal({
    component: ModalNewOrder,
    attrs: {
        cryptos: cryptos,
        symbol: symbol,
        orders: orders,
        onConfirm() {
            close()
        },
    },
});

const showNewOrderModal = async (newSymbol: string) => {
    symbol.value = newSymbol;
    open();
}
</script>