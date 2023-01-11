const Login = () => import('../../../pages/guest/Login/Login.vue');
const Registration = () => import('../../../pages/guest/Registration/Registration.vue');

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