import { defineStore } from 'pinia';
import { cookies } from '../plugins/cookies';
import { router } from '../router/router';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        isAuthenticated: false as boolean | null,
        token: null as string | null,
        roles: [] as string[] | null
    }),
    actions: {
        async authenticate(token: string, roles: string[]): Promise<any> {
            this.isAuthenticated = true;
            this.token = token;
            this.roles = roles;
            cookies.set('TOKEN', JSON.stringify(`Bearer ${token}`), 60 * 60 * 24 * 7);
            cookies.set('ROLES', JSON.stringify(roles), 60 * 60 * 24 * 7);

            await router.push({ name: 'home' });
        },
        staySignedIn(token: string, roles: string[]): void {
            this.isAuthenticated = true;
            this.token = token;
            this.roles = roles;
        },
        isAdmin(): boolean {
            if (this.roles === null) return false;

            let havePermission: boolean = false;
            this.roles.forEach(role => {
                if (role === 'ROLE_ADMIN') {
                    havePermission = true;
                }
            })

            return havePermission;
        },
        async logout(): Promise<any> {
            this.isAuthenticated = false;
            this.token = null;
            this.roles = null;
            cookies.remove('TOKEN');
            cookies.remove('ROLES');

            await router.push({ name: 'home' });
        }
    }
});