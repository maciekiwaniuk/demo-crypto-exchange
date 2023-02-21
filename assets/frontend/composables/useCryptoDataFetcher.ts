import { axiosInstance } from '../plugins/axios';

export const useCryptoDataFetcher = (): any => {
    const getPricesOfActiveCryptos = async (): Promise<any[]> => {
        let cryptos: any[] = [];

        await axiosInstance.get('api/crypto/get-prices-of-active-cryptos')
            .then(response => {
                cryptos = response.data.cryptos;
            })

        return cryptos;
    }

    return { getPricesOfActiveCryptos };
}