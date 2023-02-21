<template>
    <h1 class="text-4xl text-yellow-400">TransactionHistory page</h1>

    <br /> <br />

    List of your transactionHistory:
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
        <tr v-for="transaction in transactionHistory">
            <td class="border border-slate-600">{{ transaction.id }}</td>
            <td class="border border-slate-600">{{ transaction.type }}</td>
            <td class="border border-slate-600">{{ transaction.cryptoToBuy?.symbol }}</td>
            <td class="border border-slate-600">{{ transaction.numberOfCryptoToBuy }}</td>
            <td class="border border-slate-600">{{ transaction.cryptoToSell?.symbol }}</td>
            <td class="border border-slate-600">{{ transaction.numberOfCryptoToSell }}</td>
            <td class="border border-slate-600">{{ transaction.value }}</td>
        </tr>
    </table>

</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { axiosInstance } from '../../../plugins/axios';

const transactionHistory = reactive<any[]>([])

const getTransactionHistory = async (): Promise<any> => {
    await axiosInstance.get('/api/user/transaction-history/get-list')
        .then(response => {
            Object.assign(transactionHistory, JSON.parse(response.data.transactionHistory));
        })
}
getTransactionHistory();

</script>