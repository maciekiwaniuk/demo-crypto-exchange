import { useAuthStore } from '../stores/auth';
import cookies from 'vue-cookies';

export const checkAuthentication = () => {
    const authStore = useAuthStore(),
          JWToken = cookies.get('token'),
          roles = cookies.get('roles');

    if (JWToken && roles) {
        authStore.staySignedIn(JWToken, roles);
    }
}