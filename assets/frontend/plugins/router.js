import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import Login from '../components/guest/Login.vue';
import Registration from '../components/guest/Registration.vue';
import Settings from '../components/user/Settings.vue';

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
    console.log(to);
    console.log(from);
    console.log('----------');
})
