const Home = () => import('../../../pages/Home.vue');

export const generalRoutes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            title: 'Home'
        }
    },
];
