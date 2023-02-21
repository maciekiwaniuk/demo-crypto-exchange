const Security = () => import('../../pages/user/Security/Security.vue');
const TransactionHistory = () => import('../../pages/user/TransactionHistory/TransactionHistory.vue');
const Market = () => import('../../pages/user/Market/Market.vue');
const Trade = () => import('../../pages/user/Trade/Trade.vue');
const Wallet = () => import('../../pages/user/Wallet/Wallet.vue');

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
        path: '/user/trade',
        name: 'user.trade',
        component: Trade,
        meta: {
            title: 'User - Trade',
            requiredStatus: 'user'
        }
    },
    {
        path: '/user/wallet',
        name: 'user.wallet',
        component: Wallet,
        meta: {
            title: 'User - Wallet',
            requiredStatus: 'user'
        }
    },
    {
        path: '/user/transaction-history',
        name: 'user.transaction-history',
        component: TransactionHistory,
        meta: {
            title: 'User - Transaction history',
            requiredStatus: 'user'
        }
    }
];
