<template>
    <VueFinalModal
        class="flex justify-center items-center"
        content-class="flex flex-col max-w-xl mx-4 p-4 bg-white border dark:border-gray-700 rounded-lg space-y-2"
        overlayTransition="vfm-fade"
    >
        <h1 class="text-xl">
            {{ title }}
        </h1>

        <h2>Current crypto prices</h2>
        <table class="m-auto">
            <tr>
                <th class="border-2 border-black p-2">Cryptocurrency</th>
                <th class="border-2 border-black p-2">Price</th>
            </tr>
            <tr v-for="crypto in cryptos">
                <td class="border-2 border-black p-2">{{ crypto.symbol.replace('USDT', '') }}</td>
                <td class="border-2 border-black p-2">{{ crypto.price }} USD</td>
            </tr>
        </table>

        <button class="mt-1 ml-auto px-2 border rounded-lg" @click="emit('confirm')">
            Confirm
        </button>
    </VueFinalModal>
</template>

<script setup lang="ts">
import { VueFinalModal } from 'vue-final-modal'
defineProps<{
    title: string,
    cryptos: any[]
}>()
const emit = defineEmits<{
    (e: 'confirm'): void
}>()
</script>
