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
        async authenticate(token: string, roles: string[]): Promise<void> {
            this.isAuthenticated = true;
            this.token = token;
            this.roles = roles;

            const cookieTerm = 60 * 60 * 24 * 7;
            cookies.set('TOKEN', JSON.stringify(`Bearer ${token}`), cookieTerm);
            cookies.set('ROLES', JSON.stringify(roles), cookieTerm);

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
        async logout(): Promise<void> {
            this.isAuthenticated = false;
            this.token = null;
            this.roles = null;
            cookies.remove('TOKEN');
            cookies.remove('ROLES');

            await router.push({ name: 'home' });
        }
    }
});