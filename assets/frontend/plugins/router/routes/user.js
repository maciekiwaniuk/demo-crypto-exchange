const Settings = () => import('../../../pages/user/Settings/Settings.vue');

export const userRoutes = [
    {
        path: '/user/settings',
        name: 'user.settings',
        component: Settings,
        meta: {
            title: 'User - Settings',
            requiredStatus: 'user'
        }
    },
];
