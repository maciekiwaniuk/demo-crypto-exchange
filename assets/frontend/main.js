globalThis.__VUE_OPTIONS_API__ = true;
globalThis.__VUE_PROD_DEVTOOLS__ = false;

import App from './App.vue';
import { createApp } from 'vue';
import { router } from './plugins/router';
import { createPinia } from 'pinia';
import { checkAuthentication } from './functions/checkAuthentication';
import './main.css';

const pinia = createPinia();

createApp(App)
    .use(pinia)
    .use(router)
    .mount('#app');

checkAuthentication();