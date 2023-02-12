const Security = () => import('../../pages/user/Security/Security.vue');
const Transactions = () => import('../../pages/user/Transactions/Transactions.vue');
const Market = () => import('../../pages/user/Market/Market.vue');

export const userRoutes: any = [
    {
        path: '/user/security',
        name: 'user.security',
        component: Security,
        meta: {
            title: 'User - Security',
            requiredStatus: 'user'
        }
    },
    {
        path: '/user/market',
        name: 'user.market',
        component: Market,
        meta: {
            title: 'User - Market',
            requiredStatus: 'user'
        }
    },
    {
        path: '/user/transactions',
        name: 'user.transactions',
        component: Transactions,
        meta: {
            title: 'User - Transactions',
            requiredStatus: 'user'
        }
    }
];
