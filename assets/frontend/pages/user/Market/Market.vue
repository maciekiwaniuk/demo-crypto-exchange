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

    <br />

    <button @click="open();">Open Modal</button>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { useCryptoDataFetcher } from '../../../composables/useCryptoDataFetcher';
import { cryptoDataRefreshRate } from '../../../constants/app';
import { round } from '../../../utils/round';
import { useModal } from 'vue-final-modal';
import ModalNewOrder from './ModalNewOrder.vue';

const cryptos = reactive<any[]>([]);

const { getPricesOfActiveCryptos } = useCryptoDataFetcher();

const getCryptos = async (): Promise<void> => {
    const fetchedCryptos = await getPricesOfActiveCryptos();
    Object.assign(cryptos, fetchedCryptos);
}
getCryptos();
setInterval(() => {
    getCryptos();
}, cryptoDataRefreshRate);

const { open, close, options } = useModal({
    component: ModalNewOrder,
    attrs: {
        title: 'Place new order',
        cryptos: cryptos,
        onConfirm() {
            close()
        },
    },
    slots: {
        default: '<p>UseModal: The content of the modal</p>',
    },
});
</script>