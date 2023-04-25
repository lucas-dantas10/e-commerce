import { createApp } from 'vue';
import store from './store/index.js';
import router from './router/index.js';
import './index.css';
import App from './App.vue';

createApp(App)
.use(store)
.use(router)
.mount('#app');
