const Settings = () => import('../../pages/user/Settings/Settings.vue');

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
];
