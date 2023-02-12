const Security = () => import('../../pages/user/Security/Security.vue');
const Transactions = () => import('../../pages/user/Transactions/Transactions.vue');

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
        path: '/user/transactions',
        name: 'user.transactions',
        component: Transactions,
        meta: {
            title: 'User - Transactions',
            requiredStatus: 'user'
        }
    }
];
