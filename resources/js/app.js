import './bootstrap.js';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router/index.js';
import Customer from './customer/Customer.vue';
import { i18nVue } from 'laravel-vue-i18n';

const customerApp = createApp(Customer);
const pinia = createPinia();
customerApp
    .use(pinia)
    .use(router)
    .use(i18nVue, {
        resolve: lang => import(`../../lang/${lang}.json`),
    })
    .mount('#app');
