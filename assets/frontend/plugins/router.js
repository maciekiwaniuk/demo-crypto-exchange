import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import Login from '../components/guest/Login.vue';
import Registration from '../components/guest/Registration.vue';
import Settings from '../components/user/Settings.vue';
import Cryptocurrencies from '../components/admin/Cryptocurrencies.vue';
import { useAuthStore } from '../stores/auth';

export const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: {
                title: 'Home'
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                title: 'Login',
                requiredStatus: 'guest'
            }
        },
        {
            path: '/registration',
            name: 'registration',
            component: Registration,
            meta: {
                title: 'Registration',
                requiredStatus: 'guest'
            }
        },
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
            path: '/admin/cryptocurrencies',
            name: 'admin.cryptocurrencies',
            component: Cryptocurrencies,
            meta: {
                title: 'Admin - Cryptocurrencies',
                requiredStatus: 'admin'
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

    if (to.meta.requiredStatus === 'admin' && !authStore.isAdmin()) {
        return false;
    }

    document.title = to.meta.title;
})
