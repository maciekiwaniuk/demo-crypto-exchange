globalThis.__VUE_OPTIONS_API__ = true;
globalThis.__VUE_PROD_DEVTOOLS__ = false;

import App from './App.vue';
import { createApp } from 'vue';
import { router } from './plugins/router/router';
import { createPinia } from 'pinia';
import { checkAuthentication } from './functions/checkAuthentication';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import './main.css';

const pinia = createPinia();

const app = createApp(App);

app.use(pinia)
    .use(router)
    .use(VueSweetalert2)
    .mount('#app');

// set global access to SweetAlert2 from variable Swal
window.Swal = app.config.globalProperties.$swal;

checkAuthentication();