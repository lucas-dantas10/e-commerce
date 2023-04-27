import axiosClient from '../axios.js';

export function login({commit}, data) {
    return axiosClient.post('/login', data)
            .then((res) => {
                commit('setUser', res.data.user.original);
                commit('setToken', res.data.token);
                console.log(res.data.user.original)
                console.log(res.data.token);
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

export function getProducts({commit}, data) {
    return axiosClient.get('/product', data)
        .then((res => {
            console.log(res.data);
        }))
}