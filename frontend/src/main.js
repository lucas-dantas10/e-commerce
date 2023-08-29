import { createApp } from 'vue';
import store from './store/index.js';
import router from './router/index.js';
import './index.css';
import currencyBR from './filters/currency.js'
import App from './App.vue';

const app = createApp(App);


app.use(store)
    .use(router)
    .mount('#app');

app.config.globalProperties.$filters = {
    currencyBR
}