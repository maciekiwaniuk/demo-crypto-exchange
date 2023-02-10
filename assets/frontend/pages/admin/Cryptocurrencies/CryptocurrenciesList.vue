<template>
    List of crypto
    <br>
    <table class="m-auto">
        <tr>
            <th>Symbol</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <tr v-for="(crypto, index) in cryptos">
            <td>{{ crypto.symbol }}</td>
            <td>{{ crypto.active }}</td>
            <td>
                <button type="button" @click="deleteCrypto(crypto.id, index);">Delete</button>
            </td>
        </tr>
    </table>
</template>

<script setup lang="ts">
import { axiosInstance } from '../../../plugins/axios';
import { inject } from 'vue';

const swal = inject('$swal') as any;

interface Props {
    cryptos: any[],
}
const props = defineProps<Props>();

const deleteCrypto = async (cryptoId: number, indexInArray: number) => {
    await axiosInstance.delete(`api/admin/delete-crypto/${cryptoId}`)
        .then(response => {
            if (!response.data.success) {
                swal({
                    icon: 'error'
                });
                return;
            }
            swal({
                text: response.data.message,
                icon: 'success'
            });

            props.cryptos.splice(indexInArray, 1);
        });
}
</script>