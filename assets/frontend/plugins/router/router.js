import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../../stores/auth';
import { generalRoutes } from './routes/general';
import { guestRoutes } from './routes/guest';
import { userRoutes } from './routes/user';
import { adminRoutes } from './routes/admin';

const allRoutes = []
    .concat(generalRoutes)
    .concat(guestRoutes)
    .concat(userRoutes)
    .concat(adminRoutes);

export const router = createRouter({
    history: createWebHistory(),
    routes: allRoutes
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
