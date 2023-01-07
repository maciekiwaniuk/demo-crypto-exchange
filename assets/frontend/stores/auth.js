import { defineStore } from 'pinia';
import cookies from 'vue-cookies';
import { router } from '../plugins/router/router';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        isAuthenticated: false,
        token: null,
        roles: null
    }),
    actions: {
        async authenticate(token, roles) {
            this.isAuthenticated = true;
            this.token = token;
            this.roles = roles;
            cookies.set('token', JSON.stringify(`Bearer ${token}`), { expires: 7 });
            cookies.set('roles', JSON.stringify(roles), { expires: 7 });

            await router.push({ name: 'home' });
        },
        staySignedIn(token, roles) {
            this.isAuthenticated = true;
            this.token = token;
            this.roles = roles;
        },
        getRolesOfCurrentlyAuthenticatedUser() {
            return this.roles;
        },
        isAdmin() {
            if (this.roles === null) return false;

            let hasPermission = false;
            this.roles.forEach(role => {
                if (role === 'ROLE_ADMIN') {
                    hasPermission = true;
                }
            })

            return hasPermission;
        },
        async logout() {
            this.isAuthenticated = false;
            this.token = null;
            this.roles = null;
            cookies.remove('token');
            cookies.remove('roles');

            await router.push({ name: 'home' });
        }
    }
});