<template>
    <h1>Cryptocurrencies</h1> <br>

    <form @submit.prevent="newCryptocurrency();">
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

        List of crypto
        <br>
        <table>
            <tr>
                <th>id</th>
                <th>symbol</th>
                <th>active</th>
            </tr>

            <tr v-for="crypto in cryptocurrencies">
                <td>{{ crypto.id }}</td>
                <td>{{ crypto.symbol }}</td>
                <td>{{ crypto.active }}</td>
            </tr>
        </table>
    </form>

</template>

<script setup lang="ts">
import { axiosInstance } from '../../../plugins/axios';
import { inject, reactive, ref } from 'vue';

const swal = inject('$swal') as any;

const symbol = ref<string>(''),
      activeSelect = ref<string>(''),
      activeOptions = reactive<any>([]);

const cryptocurrencies = reactive<any>([]);

axiosInstance.get('api/admin/options_for_active_select')
    .then(response => {
        for (const [key, value] of Object.entries(response.data.options)) {
            activeOptions.push({
                value: value,
                key: key
            })
        }
    });

axiosInstance.get('api/admin/get_cryptocurrencies')
    .then(response => {
        Object.assign(cryptocurrencies, JSON.parse(response.data.cryptocurrencies));
    });

const newCryptocurrency = async () => {
    await axiosInstance.post('api/admin/new_cryptocurrency', {
        symbol: symbol.value,
        active: activeSelect.value
    })
        .then(response => {
            console.log(response);
            if (response.data.success) {
                swal({
                    text: response.data.message,
                    icon: 'success',
                })
                const newCrypto: any = JSON.parse(response.data.cryptocurrency);
                cryptocurrencies.push(newCrypto);
                return;
            }
            swal({
                text: Object.values(response.data.errors)[0],
                icon: 'error',
            })
        });
}
</script>

<style scoped>

</style>