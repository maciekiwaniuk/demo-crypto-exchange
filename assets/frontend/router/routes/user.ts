const Account = () => import('../../pages/user/Account/Account.vue');
const Transactions = () => import('../../pages/user/Transactions/Transactions.vue');

export const userRoutes: any = [
    {
        path: '/user/account',
        name: 'user.account',
        component: Account,
        meta: {
            title: 'User - Account',
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
