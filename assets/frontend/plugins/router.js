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
                auth: false
            }
        },
        {
            path: '/registration',
            name: 'registration',
            component: Registration,
            meta: {
                auth: false
            }
        },
        {
            path: '/user/settings',
            name: 'user.settings',
            component: Settings,
            meta: {
                auth: true
            }
        }
    ]
})
