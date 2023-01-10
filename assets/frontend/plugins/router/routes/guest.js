const Login = () => import('../../../components/guest/Login');
const Registration = () => import('../../../components/guest/Registration');

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