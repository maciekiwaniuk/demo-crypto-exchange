<template>
    <form @submit.prevent="newCryptocurrency();">
        <label for="symbol">Symbol</label>
        <input type="text" id="symbol" v-model="symbol"> <br>

        <label for="active">Active</label>
        <select id="active" v-model="activeSelect">
            <option v-for="option in activeOptions" :value="option.value">
                {{ option.key }}
            </option>
        </select>

        <br>

        <button type="submit" class="bg-gray-800 text-white font-bold py-2 px-4 rounded-full">
            Add
        </button>
    </form>

    <button @click="test();">TEST</button>
</template>

<script setup>
import { axiosInstance } from '../../plugins/axios';
import {reactive, ref} from 'vue';

const symbol = ref(''),
      activeSelect = ref(''),
      activeOptions = reactive([]);

axiosInstance.get('api/admin/options_for_active_select')
    .then(response => {
        for (const [key, value] of Object.entries(response.data.options)) {
            activeOptions.push({
                value: value,
                key: key
            })
        }
    });

const test = () => {
    console.log(activeSelect.value);
}

const newCryptocurrency = async () => {
    await axiosInstance.post('api/admin/new_cryptocurrency', {
        symbol: symbol.value,
        active: activeSelect.value
    })
        .then(response => {
            console.log(response);
            if (response.data.success) {
                Swal({
                    text: 'Successfully added cryptocurrency.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                })
            }
        });
}
</script>

<style scoped>

</style>