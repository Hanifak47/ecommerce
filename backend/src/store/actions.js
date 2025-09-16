// ini adalah API yang menjembatani antara backend dengan frontend

import axiosClient from "../axios";
import { PRODUCT_PER_PAGE } from '../constant.js';


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

// commit digunakan untuk set data dari set product
// parameter ini diperoleh dari view
// jika ada isinya maka ada isinya jika tidak ya kosong (untuk parameter ke 2)
export function getProducts({ commit }, { url = null, search = '', perPage = PRODUCT_PER_PAGE, sort_field, sort_direction } = {}) {

    // console.log(perPage);
    // console.log(search);


    // ini menggunakan mutationnya, true disini adalah loadingnya
    // awalnya set product memiliki nilai loading true
    commit('setProducts', [true])
    // arahkan ke routes resources agar 

    // atur nial url sesuai url pada parameter, jika url pada parameter bernilai null maka nilailnyab adalah /product 
    url = url || '/products';

    // parameter tersebut dikirim ke kontroler melalui routes api
    return axiosClient.get(url, {
        params: {
            search,
            per_page: perPage,
            sort_field,
            sort_direction
        }
    })
        // res = response, berisikan data dan metadata dari server
        // debugger;
        .then(res => {
            commit('setProducts', [false, res.data])
        })
        .catch(() => {
            commit('setProducts', [false])
        })
}

export function createProduct({ commit }, product) {
    // jika ada gambarnya maka
    if (product.image instanceof File) {
        // buat objek form baru
        const form = new FormData();

        form.append('title', product.title);
        form.append('image', product.image);
        form.append('description', product.description);
        form.append('price', product.price);
        product = form;
    }

    return axiosClient.post('/products', product)
}

// update produk
// export function updateProduct({ commit }, product) {
//     const id = product.id
//     // console.log(product)
//     // debugger
//     if (product.image instanceof File) {
//         const form = new FormData();
//         form.append('id', product.id);
//         form.append('title', product.title);
//         form.append('image', product.image);
//         form.append('description', product.description);
//         form.append('price', product.price);
//         form.append('_method', 'PUT');
//         product = form;
//     }
//     // console.log(product)
//     // debugger
//     return axiosClient.post(`/products/${id}`, product)
// }


export function updateProduct({ commit }, product) {
    // set idnya
    const id = product.id;

    if (product.image instanceof File) {
        // buat form data baru
        const form = new FormData();
        form.append('id', product.id);
        form.append('title', product.title);
        form.append('image', product.image);
        form.append('description', product.description);
        form.append('price', product.price);
        form.append('_method', 'PUT');

        // Return the request with the 'form' variable and the correct headers
        return axiosClient.post(`/products/${id}`, form, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

    } else {
        // If no image is updated, send as JSON (PUT method is fine here)
        return axiosClient.put(`/products/${id}`, product);
    }
}

// export function updateProduct({ commit }, product) {
//     const id = product.id
//     const form = new FormData()
//     form.append('title', product.title)
//     form.append('description', product.description)
//     form.append('price', product.price)
//     if (product.image instanceof File) {
//         form.append('image', product.image)
//     }
//     form.append('_method', 'PUT')

//     console.log(form)
//     debugger

//     return axiosClient.post(`/products/${id}`, form) // JANGAN .put
// }


// hapus produk
export function deleteProduct({ commit }, id) {
    return axiosClient.delete(`/products/${id}`)
}

// dapatkan 1 product saja 
export function getProduct({ commit }, id) {
    return axiosClient.get(`/products/${id}`)
}




