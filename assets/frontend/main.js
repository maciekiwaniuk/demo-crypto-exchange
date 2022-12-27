globalThis.__VUE_OPTIONS_API__ = true;
globalThis.__VUE_PROD_DEVTOOLS__ = false;

import App from './App.vue';
import { createApp } from 'vue';
import { router } from './plugins/router';
import { createPinia } from 'pinia';
import { useAuthStore } from './stores/auth';
import cookies from 'vue-cookies';
import './main.css';

const pinia = createPinia();

const app = createApp(App)
    .use(router)
    .use(pinia);

app.mount('#app');

const authStore = useAuthStore(),
      JWToken = cookies.get('token'),
      roles = cookies.get('roles');

if (JWToken && roles) {
    authStore.staySignedIn(JWToken, roles);
}