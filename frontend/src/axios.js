import axios from 'axios';
import store from './store';
import router from './router/index.js';

const axiosClient = axios.create({
    baseURL: 'http://localhost:8082/api'
});

axiosClient.interceptors.request.use(config => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`;
    return config;
});

axiosClient.interceptors.response.use(response => {
    return response;
}, error => {
    if (error.request.status === 401 ) {
        store.commit('setToken', null);
        router.push({name: 'login'});
    }
    throw error;
});

export default axiosClient;

