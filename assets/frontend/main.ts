globalThis.__VUE_OPTIONS_API__ = true;
globalThis.__VUE_PROD_DEVTOOLS__ = false;

import App from './App.vue';
import { createApp } from 'vue';
import { router } from './router/router';
import { createPinia } from 'pinia';
import { LoadingPlugin } from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import { createVfm } from 'vue-final-modal';
import 'vue-final-modal/style.css'
import './main.css';

const pinia = createPinia();

const vueFinalModal = createVfm();

const app = createApp(App);

app.use(pinia)
    // https://v3.router.vuejs.org/guide
    .use(router)

    // https://github.com/ankurk91/vue-loading-overlay
    .use(LoadingPlugin)

    // https://sweetalert2.github.io/
    .use(VueSweetalert2)

    // https://vue-final-modal.org/api/components/vue-final-modal
    .use(vueFinalModal);

app.mount('#app');
