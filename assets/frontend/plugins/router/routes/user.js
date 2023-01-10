const Settings = () => import('../../../components/user/Settings');

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
