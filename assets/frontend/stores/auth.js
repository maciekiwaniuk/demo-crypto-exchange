import { defineStore } from 'pinia';
import cookies from 'vue-cookies';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        isAuthenticated: false,
        token: null,
        roles: null
    }),
    actions: {
        staySignedIn(token, roles) {
            this.isAuthenticated = true;
            this.token = token;
            this.roles = roles;
        },
        authenticate(token, roles) {
            this.isAuthenticated = true;
            this.token = token;
            this.roles = roles;
            cookies.set('token', JSON.stringify(`Bearer ${token}`), { expires: 7 });
            cookies.set('roles', JSON.stringify(roles), { expires: 7 });
        },
        logout() {
            this.isAuthenticated = false;
            this.token = null;
            this.roles = null;
            cookies.remove('token');
            cookies.remove('roles');
        }
    }
});