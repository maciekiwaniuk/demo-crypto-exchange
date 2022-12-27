globalThis.__VUE_OPTIONS_API__ = true;
globalThis.__VUE_PROD_DEVTOOLS__ = false;

/* instance of app */
import { createApp } from 'vue';
import App from './App.vue';
const app = createApp(App);

/* router */
import { router } from './plugins/router';
app.use(router);

/* import pinia for state management */
import { createPinia } from 'pinia';
const pinia = createPinia();
app.use(pinia);

/* import styles (tailwind css) */
import './main.css';

/* mount app */
app.mount('#app');

/* auth store */
import { useAuthStore } from './stores/auth';
const authStore = useAuthStore(),
      JWToken = localStorage.getItem('token') ?? false;
if (JWToken) {
    authStore.setAuthenticationToken(JWToken);
}
