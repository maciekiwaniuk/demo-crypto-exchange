const Settings = () => import('../../pages/user/Settings/Settings.vue');
const Transactions = () => import('../../pages/user/Transactions/Transactions.vue');

export const userRoutes: any = [
    {
        path: '/user/settings',
        name: 'user.settings',
        component: Settings,
        meta: {
            title: 'User - Settings',
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
