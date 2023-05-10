import axiosClient from '../axios.js';
import state from './state.js';

export function login({commit}, data) {
    return axiosClient.post('/login', data)
            .then(({data}) => {
                commit("setUser", data.user.original);
                commit("setToken", data.token);
                return data;
            })
}

export function logout({commit}) {
    return axiosClient.post('/logout')
      .then((response) => {
            commit('setToken', null);
    
            return response;
      
        })
}

export function getCurrentUser({commit, state}, user) {
    return axiosClient('/user', user.id)
        .then(res => {
            console.log(res.data);
        })
        .catch(err => {
            console.log(err);
        })
}

export function getProducts({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
    commit('setProducts', [true]);

    url = url || '/product';

    const params = {
        per_page: state.products.limit
    };

    return axiosClient.get(url, {
        params: {
            ...params,
            search, sort_field, sort_direction, per_page
        }
    })
    .then(res => {
        commit('setProducts', [false, res.data]);
    })
    .catch(err => {
        console.log(err);
        commit('setProducts', [false]);
    })
}

export function getProduct({commit}, idProduct) {
    return axiosClient.get(`/product/${idProduct}`);
}

export function deleteProduct({commit}, idProduct) {
    return axiosClient.delete(`/product/${idProduct}`);
}

export function updateProduct({commit}, product) {

    const id = product.id;
    if (product.image instanceof File) {
        const form = new FormData();
        form.append("id", product.id);
        form.append('title', product.title);
        form.append('image', product.image);
        form.append('price', product.price);
        form.append('description', product.description || '');
        form.append('published', product.published);
        form.append('_method', 'PUT');
        product = form;
    } else {
        product._method = 'PUT'
    }

    return axiosClient.post(`/product/${id}`, product);
}

export function createProduct({commit}, product) {
    if (product.image instanceof File) {
        const form = new FormData();
        form.append('title', product.title);
        form.append('image', product.image);
        form.append('price', product.price);
        form.append('description', product.description);
        form.append('published', product.published);
        product = form;
    }

    return axiosClient.post('/product', product);
}

export function getUsers({commit, state}, {url = null, search = '', perPage, sort_field, sort_direction } = {}) {
    commit("setUsers", [true]);

    url = url || '/users';

    const params = {
        perPage: state.users.limit
    };

    return axiosClient.get(url, {
        ...params,
        sort_field, sort_direction, search, perPage
    })
    .then(res => {
        console.log(res.data);
        commit("setUsers", [false, res.data]);
    })
    .catch(err => {
        console.log(err);
        commit('setUsers', [false]);
    })
}