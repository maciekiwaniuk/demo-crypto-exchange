const Home = () => import('../../pages/Home.vue');

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
