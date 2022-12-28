import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import Login from '../components/guest/Login.vue';
import Registration from '../components/guest/Registration.vue';
import Settings from '../components/user/Settings.vue';
import { useAuthStore } from '../stores/auth';

export const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                requiredStatus: 'guest'
            }
        },
        {
            path: '/registration',
            name: 'registration',
            component: Registration,
            meta: {
                requiredStatus: 'guest'
            }
        },
        {
            path: '/user/settings',
            name: 'user.settings',
            component: Settings,
            meta: {
                requiredStatus: 'user'
            }
        }
    ]
});

router.beforeEach((to, from) => {
    const authStore = useAuthStore();

    if (to.meta.requiredStatus === 'guest' && authStore.isAuthenticated) {
        return false;
    }

    const needToBeLoggedIn = (to.meta.requiredStatus === 'user' || to.meta.requiredStatus === 'admin');
    if (needToBeLoggedIn && !authStore.isAuthenticated) {
        return false;
    }

    if (to.meta.requiredStatus === 'admin') {
        const roles = authStore.getRolesOfCurrentlyAuthenticatedUser(),
              adminRule = 'ROLE_ADMIN';

        let foundAdminRule = false;
        roles.forEach(role => {
            if (role === adminRule) foundAdminRule = true;
        });

        if (!foundAdminRule) return false;
    }
})
