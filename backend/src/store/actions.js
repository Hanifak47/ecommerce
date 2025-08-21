// import axiosClient from "../axios";

// export function login({ commit }, data) {

//     return axiosClient.post('/login', data)
//         .then(({ data }) => {
//             commit('setUser', data.user);
//             commit('setToken', data.token)
//             return data;
//         })
// }

// // jika logout maka tokennya dilogout
// export function logout({commit}) {
//     return axiosClient.post('/logout')
//       .then((response) => {
//         commit('setToken', null)

//         return response;
//       })
//   }



import axiosClient from "../axios";

export function getUser({ commit }, data) {
    return axiosClient.get('/user', data)
        .then(({ data }) => {
            commit('setUser', data);
            return data;
        })
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


