import { useAuthStore } from '../stores/auth';
import cookies from 'vue-cookies';

export const checkAuthentication = () => {
    const authStore = useAuthStore(),
          JWToken = cookies.get('TOKEN'),
          roles = cookies.get('ROLES');

    if (JWToken && roles) {
        authStore.staySignedIn(JWToken, roles);
    }
}