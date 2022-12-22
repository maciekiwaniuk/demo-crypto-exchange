globalThis.__VUE_OPTIONS_API__ = true;
globalThis.__VUE_PROD_DEVTOOLS__ = false;

/* instance of app */
import { createApp } from 'vue';
import App from './App.vue';
const app = createApp(App);

/* import pinia for state management */
import { createPinia } from 'pinia';
const pinia = createPinia();
app.use(pinia);

/* mount app */
app.mount('#app');