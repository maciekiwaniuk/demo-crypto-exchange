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
            cookies.set('TOKEN', JSON.stringify(`Bearer ${token}`), { expires: 7 });
            cookies.set('ROLES', JSON.stringify(roles), { expires: 7 });

            await router.push({ name: 'home' });
        },
        staySignedIn(token, roles) {
            this.isAuthenticated = true;
            this.token = token;
            this.roles = roles;
        },
        isAdmin() {
            if (this.roles === null) return false;

            let havePermission = false;
            this.roles.forEach(role => {
                if (role === 'ROLE_ADMIN') {
                    havePermission = true;
                }
            })

            return havePermission;
        },
        async logout() {
            this.isAuthenticated = false;
            this.token = null;
            this.roles = null;
            cookies.remove('TOKEN');
            cookies.remove('ROLES');

            await router.push({ name: 'home' });
        }
    }
});