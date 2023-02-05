<template>
    <h1>Transactions</h1>

    List:
    <div v-for="transaction in transactions">
        tako <br/>
    </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { axiosInstance } from '../../../plugins/axios';

const transactions = reactive<any[]>([]);

const getTransactions = async () => {
    axiosInstance.get('/api/user/transactions')
        .then(response => {
            console.log(response);
        })
}
getTransactions();

</script>