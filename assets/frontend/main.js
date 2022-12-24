globalThis.__VUE_OPTIONS_API__ = true;
globalThis.__VUE_PROD_DEVTOOLS__ = false;

/* instance of app */
import { createApp } from 'vue';
import App from './App.vue';
const app = createApp(App);

/* router */
import { router } from './router';
app.use(router);

/* import pinia for state management */
import { createPinia } from 'pinia';
const pinia = createPinia();
app.use(pinia);

/* import styles (tailwind css) */
import './main.css';

/* mount app */
app.mount('#app');