import './bootstrap.js';
import { createApp } from 'vue';
import { createPinia } from 'pinia'; // استيراد Pinia
import router from './router/driver.js';
import Driver from './driver/Driver.vue';
import { i18nVue } from 'laravel-vue-i18n';
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs';

const DriverApp = createApp(Driver);
const pinia = createPinia(); // إنشاء متجر Pinia

DriverApp
    .use(pinia) // استخدام Pinia
    .use(router)
    .use(i18nVue, {
        resolve: lang => import(`../../lang/${lang}.json`),
    })
    .use(LaravelPermissionToVueJS)
    .mount('#driver');
