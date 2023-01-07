import Login from '../../../components/guest/Login';
import Registration from '../../../components/guest/Registration';

export const guestRoutes = [
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            title: 'Login',
            requiredStatus: 'guest'
        }
    },
    {
        path: '/registration',
        name: 'registration',
        component: Registration,
        meta: {
            title: 'Registration',
            requiredStatus: 'guest'
        }
    },
];