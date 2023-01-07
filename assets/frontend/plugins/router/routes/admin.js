import Cryptocurrencies from '../../../components/admin/Cryptocurrencies';

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