<template>
    <VueFinalModal
        class="flex justify-center items-center"
        content-class="flex flex-col max-w-xl mx-4 p-4 bg-white border dark:border-gray-700 rounded-lg space-y-2"
        overlayTransition="vfm-fade"
    >
        <h1 class="text-xl">
            Place order for {{ selectedCrypto.symbol }}
        </h1>

        <form @submit.prevent="newOrder();">
            <label for="price">Price</label>
            <input type="price" v-model="price">

            <br /> <br />
            <label for="amount">Amount</label>
            <input type="amount" v-model="amount">

            <br /> <br />
            <label for="valueOfOrder">Value</label>
            <input type="valueOfOrder" v-model="valueOfOrder">

            <br /> <br />
            <button class="mt-1 ml-auto px-2 border rounded-lg" type="submit">New order</button>
        </form>

        <button class="mt-1 ml-auto px-2 border rounded-lg" @click="emit('confirm')">
            Confirm
        </button>
    </VueFinalModal>
</template>

<script setup lang="ts">
import { VueFinalModal } from 'vue-final-modal'
import { ref, computed } from 'vue';
import { axiosInstance } from '../../../plugins/axios';

const props = defineProps<{
    symbol: string
    cryptos: any[]
}>();

const emit = defineEmits<{
    (e: 'confirm'): void
}>();

const selectedCrypto: any = computed(() => {
    return props.cryptos.find(crypto => crypto.symbol === props.symbol);
});

const price = ref<number>(selectedCrypto.value.price),
      amount = ref<number>(0);

const valueOfOrder: any = computed(() => {
    return price.value * amount.value;
});

const newOrder = async (): Promise<void> => {
    await axiosInstance.post('/api/user/market/new-buy-order', {
        cryptoToBuySymbol: selectedCrypto.value.symbol,
        amountOfCryptoToBuy: amount.value,
        value: valueOfOrder.value
    })
        .then(response => {
            console.log(response);
        })
        .catch(error => {
            console.log(error);
        });
}
</script>
