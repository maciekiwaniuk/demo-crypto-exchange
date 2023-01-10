const Home = () => import('../../../components/Home');

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
