const Cryptocurrencies = () => import('../../../pages/admin/Cryptocurrencies/Cryptocurrencies.vue');

export const adminRoutes = [
    {
        path: '/admin/cryptocurrencies',
        name: 'admin.cryptocurrencies',
        component: Cryptocurrencies,
        meta: {
            title: 'Admin - Cryptocurrencies',
            requiredStatus: 'admin'
        }
    }
];