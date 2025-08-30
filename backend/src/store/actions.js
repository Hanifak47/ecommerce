// ini adalah API yang menjembatani antara backend dengan frontend

import axiosClient from "../axios";

// export function getUser({ commit }, data) {
//     return axiosClient.get('/user', data)
//         .then(({ data }) => {
//             commit('setUser', data);
//             return data;
//         })
// }

// commit digunakan untuk mengutak atik mutation contoh commit setuser data
export function getUser({ commit }, data) {
    return axiosClient.get('/user', data)
        .then(({ data }) => {
            commit('setUser', data);
            return data;
        });
}


// jika login bawakkan data usernya serta bawakan token loginya

export function login({ commit }, data) {
    return axiosClient.post('/login', data)
        .then(({ data }) => {
            commit('setUser', data.user);
            commit('setToken', data.token)
            return data;
        })
}

// jika logout maka tokennya dilogout

// ini yg ori dari tutor
// export function logout({ commit }) {
//     return axiosClient.post('/logout')
//         .then((response) => {
//             commit('setToken', null)

//             return response;
//         })

// }

export function logout({ commit }) {
    // Kirim permintaan logout ke backend
    return axiosClient.post('/logout')
        .then((response) => {
            // Blok ini hanya dieksekusi jika permintaan BERHASIL
            commit('setToken', null) // Hapus token dari state
            sessionStorage.removeItem('TOKEN'); // Hapus token dari session storage

            return response;
        })
        .catch(error => {
            // Blok ini akan dieksekusi jika permintaan GAGAL
            console.error("Logout request failed:", error);

            // Meskipun gagal, tetap hapus token di frontend
            commit('setToken', null)
            sessionStorage.removeItem('TOKEN');

            // Anda bisa lemparkan error kembali jika perlu
            // throw error; 
        });
}

export function getProducts({ commit }) {
    // ini menggunakan mutationnya, true disini adalah loadingnya
    commit('setProducts', [true])
    // arahkan ke routes resources agar 
    return axiosClient.get('/product')
        // res = response, berisikan data dan metadata dari server
        // debugger;
        .then(res => {
            commit('setProducts', [false, res.data])
        })
        .catch(() => {
            commit('setProducts', [false])
        })
}



