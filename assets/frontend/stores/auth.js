import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        isAuthenticated: false,
        token: null,
        user: null
    }),
    actions: {
        setAuthenticationToken(token) {
            this.isAuthenticated = true;
            this.token = token;
        },
        setUser(user) {
            this.user = user;
        },
        logout() {
            this.isAuthenticated = false;
            this.token = null;
            this.user = null;
        }
    }
});