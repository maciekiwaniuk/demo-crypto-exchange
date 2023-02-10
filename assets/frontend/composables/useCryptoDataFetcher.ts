import { axiosInstance } from '../plugins/axios';

export const useCryptoDataFetcher = (): any => {
    const getPricesOfActiveCryptos = async (): Promise<any[]> => {
        let cryptos: any[] = [];

        await axiosInstance.get('api/get-prices-of-active-cryptos')
            .then(response => {
                cryptos = response.data.cryptos;
            })

        return cryptos;
    }

    return { getPricesOfActiveCryptos };
}