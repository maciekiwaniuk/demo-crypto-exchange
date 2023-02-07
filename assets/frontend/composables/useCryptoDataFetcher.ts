import { axiosInstance } from '../plugins/axios';

export const useCryptoDataFetcher = (): any => {
    const getPricesOfActiveCryptos = async (): Promise<any[]> => {
        let cryptos: any[] = [];

        await axiosInstance.get('api/get_prices_of_active_cryptos')
            .then(response => {
                cryptos = response.data.cryptos;
            })

        return cryptos;
    }

    return { getPricesOfActiveCryptos };
}