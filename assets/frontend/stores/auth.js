import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        isAuthenticated: false,
        token: null,
        user: null
    }),
    actions: {
        login(token, user) {
            this.isAuthenticated = true;
            this.token = token;
            this.user = user;
        },
        logout() {
            this.isAuthenticated = false;
            this.token = null;
            this.user = null;
        }
    }
});