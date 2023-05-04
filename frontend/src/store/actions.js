import axiosClient from '../axios.js';

export function login({commit}, data) {
    return axiosClient.post('/login', data)
            .then((res) => {
                commit('setUser', res.data.user.original);
                commit('setToken', res.data.token);
                return res;
            })
}

export function logout({commit}) {
    return axiosClient.post('/logout')
      .then((response) => {
            commit('setToken', null);
    
            return response;
      
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
    return axiosClient.put(`/product/${product}`);
}

export function createProduct({commit}, product) {
    if (product.image instanceof File) {
        const form = new FormData();
        form.append('title', product.title);
        form.append('image', product.image);
        form.append('price', product.price);
        form.append('description', product.description);
        form.append('published', product.published);
        form.append('updated_at', product.updated_at);
        product = form;
    }

    return axiosClient.post('/product', product);
}