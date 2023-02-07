import { useAuthStore } from '../stores/auth';
import { cookies } from '../plugins/cookies';

export const useAuthenticator = (): any => {
    const checkAuthentication = (): void => {
        const authStore = useAuthStore(),
              JWToken = cookies.get('TOKEN'),
              roles = cookies.get('ROLES');

        if (JWToken && roles) {
            authStore.staySignedIn(JWToken, roles);
        }
    }

    return { checkAuthentication };
}