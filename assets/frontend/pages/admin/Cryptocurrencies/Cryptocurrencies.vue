<template>
    <h1>Cryptocurrencies</h1> <br>

    <form @submit.prevent="newCrypto();">
        <label for="symbol">Symbol</label>
        <input type="text" id="symbol" v-model="symbol"> <br>

        <label for="active">Status</label>
        <select id="active" v-model="activeSelect">
            <option v-for="option in activeOptions" :value="option.value">
                {{ option.key }}
            </option>
        </select>

        <br>

        <button
            type="submit"
            class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full"
        >Add
        </button>

        <br>

        <CryptocurrenciesList :cryptos="cryptos" />

    </form>

</template>

<script setup lang="ts">
import { axiosInstance } from '../../../plugins/axios';
import { inject, reactive, ref } from 'vue';
import CryptocurrenciesList from "./CryptocurrenciesList.vue";
import { Crypto } from '../../../interfaces/Crypto';

const swal = inject('$swal') as any;

const symbol = ref<string>(''),
      activeSelect = ref<string>(''),
      activeOptions = reactive<any>([]);

const cryptos = reactive<Crypto[]>([]);

axiosInstance.get('api/admin/get_options_for_active_select')
    .then(response => {
        for (const [key, value] of Object.entries(response.data.options)) {
            activeOptions.push({
                value: value,
                key: key
            })
        }
    });

axiosInstance.get('api/admin/get_cryptos')
    .then(response => {
        Object.assign(cryptos, JSON.parse(response.data.cryptos));
    });

const newCrypto = async () => {
    await axiosInstance.post('api/admin/new_crypto', {
        symbol: symbol.value,
        active: activeSelect.value
    })
        .then(response => {
            if (!response.data.success) {
                swal({
                    text: Object.values(response.data.errors)[0],
                    icon: 'error',
                });
                return;
            }
            swal({
                text: response.data.message,
                icon: 'success',
            });
            const newCrypto: any = JSON.parse(response.data.crypto);
            cryptos.push(newCrypto);
        });
    symbol.value = '';
}


</script>

<style scoped>

</style>