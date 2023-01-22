import { defineStore } from 'pinia';
import { cookies } from '../plugins/cookies';
import { router } from '../plugins/router/router';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        isAuthenticated: false as boolean | null,
        token: null as string | null,
        roles: [] as [] | null
    }),
    actions: {
        async authenticate(token, roles) {
            this.isAuthenticated = true;
            this.token = token;
            this.roles = roles;
            cookies.set('TOKEN', JSON.stringify(`Bearer ${token}`), 7);
            cookies.set('ROLES', JSON.stringify(roles), 7);

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