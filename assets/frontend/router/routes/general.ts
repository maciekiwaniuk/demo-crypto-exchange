const Home = () => import('../../pages/general/Home.vue');

export const generalRoutes: any = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            title: 'Home'
        }
    },
];
