import { defineStore } from 'pinia';
import { axiosInstance } from '../plugins/axios';
import { useAuthStore } from './auth';

interface UserData {
    balance: number,
    banStatus: boolean,
    isVerified: boolean,
    lastLoginIp: string,
    lastLoginTime: string
}

export const useUserStore = defineStore('user', {
    state: () => ({
        balance: null as null | number,
        banStatus: null as null | boolean,
        isVerified: null as null | boolean,
        lastLoginIp: null as null | string,
        lastLoginTime: null as null | string
    }),
    actions: {
        isUserDataAlreadyFetched () : boolean {
            return this.balance !== null;
        },
        async fetchUserData(): Promise<any> {
            await axiosInstance.get('/api/user/data')
                .then(response => {
                    const userData: UserData = response.data.userData;

                    this.balance = userData.balance;
                    this.banStatus = userData.banStatus;
                    this.isVerified = userData.isVerified;
                    this.lastLoginIp = userData.lastLoginIp;
                    this.lastLoginTime = userData.lastLoginTime;
                })
                .catch(error => {
                    const authStore = useAuthStore();
                    authStore.logout();
                });
        }
    }
});